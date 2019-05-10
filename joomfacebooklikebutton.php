<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Plugins/JoomFacebookLikeButton/trunk/joomfacebooklikebutton.php $
// $Id: joomfacebooklikebutton.php 2270 2010-08-19 15:59:46Z chraneco $
/******************************************************************************\
**   JoomGallery Plugin 'JoomFacebookLikeButton' 1.5 BETA                     **
**   By: JoomGallery::ProjectTeam                                             **
**   Copyright (C) 2012  Chraneco                                             **
**   Released under GNU GPL Public License                                    **
**   License: http://www.gnu.org/copyleft/gpl.html                            **
\******************************************************************************/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

/**
 * JoomGallery Plugin 'JoomFacebookLikeButton'
 *
 * @package     Joomla
 * @subpackage  JoomGallery
 * @since       1.0
 */
class plgJoomGalleryJoomFacebookLikeButton extends JPlugin
{
  /**
   * onJoomDisplayIcons method
   *
   * Method is called by the view when icons should be displayed
   *
   * @access  public
   * @param   object  $image  Holds the image information
   * @return  void
   * @since   1.0
   */
  function onJoomDisplayIcons($context, $image)
  {
    $html = '';

    if($context == 'detail.image')
    {
      $app    = JFactory::getApplication('site');
      $doc    = JFactory::getDocument();
      $uri    = JURI::getInstance();
      $ambit  = JoomAmbit::getInstance();

      $tag = '
  <meta property="og:title" content="'.$image->imgtitle.'" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="'.$uri->toString().'" />
  <meta property="og:image" content="'.$ambit->getImg('thumb_url', $image).'" />
  <meta property="og:site_name" content="'.$app->getCfg('sitename').'" />
  <meta property="fb:admins" content="'.$this->params->get('admins').'" />';

      if($image->imgtext)
      {
        $tag .= '
  <meta property="og:description" content="'.strip_tags($image->imgtext).'" />';
      }
      $doc->addCustomTag($tag);

      $iframe  =  'http://www.facebook.com/plugins/like.php?href=';
      $iframe .=  urlencode($uri->toString());
      $iframe .=  '&amp;layout='.$this->params->get('layout', 'standard');
      $iframe .=  '&amp;show_faces='.$this->params->get('show_faces', 'false');
      $iframe .=  '&amp;width='.$this->params->get('width', '450');
      $iframe .=  '&amp;height='.$this->params->get('height', '27');
      $iframe .=  '&amp;action='.$this->params->get('action', 'like');
      $iframe .=  '&amp;font='.$this->params->get('font', '');
      $iframe .=  '&amp;colorscheme='.$this->params->get('colorscheme', 'light');

      $html = '<span style="vertical-align:bottom"><iframe src="'.$iframe.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$this->params->get('width', '450').'px; height:'.$this->params->get('height', '27').'px; vertical-align:bottom;" allowTransparency="true"></iframe></span>';
    }

    return $html;
  }
}