<?php
/**
 * ECommentsBaseWidget class file.
 *
 * @author Dmitry Zasjadko <segoddnja@gmail.com>
 * @link https://github.com/segoddnja/ECommentable
 */

/**
 * Base class for allmodule widgets
 *
 * @version 1.0
 * @package Comments module
 */

class ECommentsBaseWidget extends DaWidget {     
  /**
   * @var class for unwatching comments
   */
  public $classUnWatchCommentView = "unWatch";
  /**
   * @var is object BlogPost
   */
  public $isObjectBlog = false;
  /**
   * @var is owner blog or not
   */
  public $isOwnerBlog = false;
  /**
   * @var id attribute
   */
  public $id = 'commentsUID';
  /**
   * @var model for displaying comments
   */
  public $model;

  /**
   * If only registered users can post comments
   * @var registeredOnly
   */
  public $registeredOnly = false;
  
  /**
   * Use captcha validation on posting
   * @var registeredOnly
   */
  public $useCaptcha = false;
  
  /**
   * Action for posting comments, where add comment form is submited
   * @var postCommentAction
   */
  public $postCommentAction = 'comments/comment/postComment';
  
  /**
   * @var array
   */
  protected $_config;

  /**
   * Initializes the widget.
   */
  public function init() {
    parent::init();
    //get comments module
    $commentsModule = Yii::app()->getModule('comments');
    //get model config for comments module
    $this->_config = $commentsModule->getModelConfig();
    if(count($this->_config) > 0) {
      $this->registeredOnly = isset($this->_config['registeredOnly']) ? $this->_config['registeredOnly'] : $this->registeredOnly;
      $this->useCaptcha = isset($this->_config['useCaptcha']) ? $this->_config['useCaptcha'] : $this->useCaptcha;
      $this->postCommentAction = isset($this->_config['postCommentAction']) ? $this->_config['postCommentAction'] : $this->postCommentAction;
    }
    $this->registerScripts();
  }

  /**
   * Registers the JS and CSS Files
   */
  protected function registerScripts() {
    $this->registerJsFile('comments.js');
    $this->registerCssFile('comment.css');
  }
  
  /**
   * Create new comment model and initialize it with owner data
   * @return CommentYii
   */
  protected function createNewComment() {
    $comment = BaseActiveRecord::newModel('CommentYii');
    $comment->id_object = $this->model->getIdObject();
    $comment->id_instance = $this->model->getIdInstance();
    return $comment;
  }
  
}

