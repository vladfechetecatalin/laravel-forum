<?php namespace Atrakeur\Forum\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ForumTopic extends AbstractForumBaseModel
{

	use SoftDeletingTrait;

	protected $table      = 'forum_topics';
	public    $timestamps = true;
	protected $dates      = ['deleted_at'];
	protected $appends    = array('replyCount', 'url', 'postUrl', 'canPost');
	protected $guarded    = array('id');

	public function category()
	{
		return $this->belongsTo('\Atrakeur\Forum\Models\ForumCategory', 'parent_category');
	}

	public function author()
	{
		return $this->belongsTo(\Config::get('forum::integration.usermodel'), 'author_id');
	}

	public function messages()
	{
		return $this->hasMany('\Atrakeur\Forum\Models\ForumMessage', 'parent_topic');
	}

	public function getReplyCountAttribute()
	{
		return $this->messages()->where('status', 'approved')->count();
	}

	public function getUrlAttribute()
	{
		$topicTitle = \App::getLocale() == 'en' && $this->category->title_en ? 'title_en' : 'title';
		$categoryTitle = \App::getLocale() == 'en' && $this->title_en ? 'title_en' : 'title';

		return action(\Config::get('forum::integration.viewcontroller').'@getTopic',
			array(
				'categoryId'  => $this->category->id,
				'categoryUrl' => \Str::slug($this->category->$categoryTitle, '_'),
				'topicId'     => $this->id,
				'topicUrl'    => \Str::slug($this->$topicTitle, '_'),
			)
		);
	}

	public function getPostUrlAttribute()
	{

		$topicTitle = \App::getLocale() == 'en' && $this->category->title_en ? 'title_en' : 'title';
		$categoryTitle = \App::getLocale() == 'en' && $this->title_en ? 'title_en' : 'title';

		return action(\Config::get('forum::integration.postcontroller').'@postNewMessage',
			array(
				'categoryId'  => $this->category->id,
				'categoryUrl' => \Str::slug($this->category->$categoryTitle, '_'),
				'topicId'     => $this->id,
				'topicUrl'    => \Str::slug($this->$topicTitle, '_'),
			)
		);
	}

	public function getCanPostAttribute()
	{
		return $this->computeCanPostAttribute('rights.posttopic');
	}

}
