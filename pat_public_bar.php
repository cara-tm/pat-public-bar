/**
 * pat_public_bar Textpattern CMS plugin
 * @author:  © Patrick LEFEVRE, all rights reserved. <patrick[dot]lefevre[at]gmail[dot]com>
 * @link:    http://pat-public-bar.cara-tm.com
 * @type:    Admin+Public
 * @prefs:   no
 * @order:   5
 * @version: 0.3.3
 * @license: GPLv2
*/

/**
 * This plugin tag registry.
 *
 */
if (class_exists('Textpattern_Tag_Registry')) {
	Txp::get('Textpattern_Tag_Registry')
		->register('pat_public_bar');
}

if (@txpinterface == 'admin') {

	global $prefs;

	register_callback('_pat_public_bar_prefs', 'prefs', '', 1);
	register_callback('_pat_public_bar_cleanup', 'plugin_lifecycle.pat_public_bar', 'deleted');

	if ( $prefs['siteurl'] != $prefs['pat_admin_url'] )
		// Restore the txp_login_public cookie with its value on the main domain if TXP is located on a sub domain.
		setcookie('txp_login_public', cs('txp_login_public'), 0, '/', '.'.$prefs['siteurl']);

}

/**
 * Inject an HTML block on the public side for all login-in users.
 * Allow access side to side from public to admin pages.
 *
 * @param  $atts  $things
 * @return HTML content for login-in users
 */
function pat_public_bar($atts, $things = NULL) {

	global $pretext, $thisarticle, $thiscomment;

	extract(lAtts(array(
		'interface' 	=> hu.'textpattern',
		'bgcolor' 	=> 'rgba(0,0,0,.8)',
		'color' 	=> '#fff',
	), $atts));

	if ( cs('txp_pat_public_bar') ) {

		$_pat_txp = _pat_protocol()._pat_sanitize_uri($interface); 

		/* List of user privs who have full bar access:
		   1 = administrators
		   2 = administrator assistants
		   6 = designers
		*/

		$pat_privs_array = array(1, 2, 6);

		ob_end_clean();

		if ( in_array(cs('txp_pat_public_bar'), $pat_privs_array) ) {

			$section = ucfirst(gTxt('section')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=section&amp;step=section_edit&amp;name='.$pretext['s'].'">'.gTxt('edit').' ('.ucfirst(gTxt('section')).' '.$pretext['s'].')</a>';
			$page = ' | '.ucfirst(gTxt('page')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=page&amp;name='.$pretext['page'].'&amp;_txp_token='.form_token().'">'.gTxt('edit').' ('.gTxt('page').' '.$pretext['page'].')</a>';
			$style = ' | '.strtoupper(gTxt('css')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=css">'.gTxt('edit').'</a> | ';

		}
		$add = ucfirst(gTxt('article')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=article&amp;Section='.$pretext['s'].'">'.gTxt('add').' ('.gTxt('section').' '.$pretext['s'].')</a>';
		$article = (
		$thisarticle['thisid'] ? 
		$add.' / <a href="'.$_pat_txp.'/index.php?event=article&amp;step=edit&amp;ID='.$thisarticle['thisid'].'&amp;_txp_token='.form_token().'">'.gTxt('edit').'</a>' : 
		$add 
		);
		$category = ( ($thisarticle['category1'] || $thisarticle['category2']) ? '&nbsp;| '.ucfirst(gTxt('category')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=category">'.gtxt('edit').'</a>' : '');
		$comment = ($thisarticle['comments_count'] > 0 ? '&nbsp;| '.ucfirst(gTxt('comment')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=discuss">'.gTxt('edit').'</a>' : '');
		$image = ($thisarticle['article_image'] ? '&nbsp;| '.ucfirst(gTxt('image')).'&nbsp;:&nbsp;<a href="'.$_pat_txp.'/index.php?event=image&amp;step=image_edit&amp;id='._pat_one_pic().'&amp;_txp_token='.form_token().'">'.gTxt('edit').'</a>' : '');
		$disconnect = '<b><a href="'.$_pat_txp.'/index.php?logout=1">'.gTxt('logout').'</a></b>';
	
		return <<<EOT
	
<div id="pat-previewer-plugin"><span><img width="22" height="22" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAQAAADZc7J/AAABv0lEQVR4AZWUr66zMBiHmyw5CReAw2HxqJkKZC22vrYed+SS+VrU9LmCXcHuYXYGh3o+0lDC3tNvH19/ipHn2fsHUPJQcyNQo45FXEb8yYOR5iPYUOYENT+8AHhy+1CFwXMlKrL4qgiUeRyLoiAq9vidif254/6Kq6QQuBAUmd797qogbMUfwhUXvnZXGid7T+eRxQ3dO866d4nDRI/EKwaJo1TcuzwvegxO4Kn8L3pCuqsIGcFIT4fGZ3DPi5Eq3ZEtPJijYMCgaRne8BMjE0Y+yk0cYpq8BSYClnZJw7fA29y7UBO4b4vzm+JMheYmcSGIKXG7xX1D7NRhCBLPC2Suq2KU+FGBIgA/Gw4X1P8Jql3v8GTAHhXIxcFMh8JijgkkDi98nIBDHxCIvV8BeODRlL8VWVxM3q4Kh6FZa9nyTzzGMEdFj6HAo4VA4KfM3rtNod9n8Rs/YyQeo5lWRUeJSxuReMt5w2XatQq7RKelyn/XEhdVpEYcDT02CTw+jq7J43IW3DFYWkz8qHJOn6csLmM2Rb9kSK9vjWLI4zL0EBXdkmv8iRMXHDMOdSjp0QoUiqQY0hfpUDwzC476A2M87nWHub3fAAAAAElFTkSuQmCC" aria-hidden= true alt="pat-public-admin-bar for TXP CMS" /> <a href="{$_pat_txp}" style="color:#ffda44">Textpattern CMS</a>&nbsp;&bull; {$section} {$page} {$style} {$article} {$category} {$comment} {$image} {$disconnect} &bull;</span></div><style scoped>#pat-previewer-plugin{position:relative;position:fixed;z-index:1000;top:0;left:0;width:100%;border-top:10px solid {$bgcolor};color:{$color};font-size:14px;line-height:40px;font-family:"HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;font-weight:300;cursor:default;box-shadow:0 3px 5px rgba(0,0,0,0.3)}#pat-previewer-plugin span{display:none;position:absolute;top:-10px;left:0;float:left;width:100%;margin:0 auto 0;padding:0 2.5%;transform-origin:50% 0;transform:scaleY(.8)}#pat-previewer-plugin:hover{}#pat-previewer-plugin:hover span{display:block;background:{$bgcolor};transform:scaleY(1)}#pat-previewer-plugin span b{float:right;font-weight:normal}#pat-previewer-plugin img{display:inline;width:22px;margin:0;vertical-align:middle}#pat-previewer-plugin a{color:#fff}</style>

EOT;

	} else {
		return '';
	}
}

/**
 * Check protocol
 *
 * @param  string  $type
 * @return string  URI or protocol security value for cookie
 */
function _pat_protocol($type)
{
	$uri = strtolower( substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/')) );

	if ($type === 'cookie')
		$out = ($uri == 'http' ? '0' : '1');
	else
		$out = $uri.'://';

	return $out;

}

/**
 * Keep only domain name and extension from URI
 * 
 * @param  $str   String
 * @return string URI without protocol
 */
function _pat_sanitize_uri($str)
{

	return preg_replace('#^https?://(w{3}\.)?#', '', $str);

}

/**
 * Retrieve only the first article image from a list
 *
 * @param 
 * @return integer  article image ID
 */
function _pat_one_pic()
{

	global $thisarticle;

	$pics = $thisarticle['article_image'];
	$pos = strpos($pics, ',');
	if ($pos)
		$pic = substr( $pics, 0, $pos );

	return $pic;
}


/**
 * Plugin prefs: TXP admin URL.
 *
 */
function _pat_public_bar_prefs()
{
	global $prefs;

	$pat_interface = hu.'textpattern';

	if ( $prefs['siteurl'] != $_SERVER['HTTP_HOST'].preg_replace('#[/\\\\]$#', '', dirname(dirname($_SERVER['SCRIPT_NAME']))) )
		$pat_interface = 'http'.( isset($_SERVER['HTTPS']) ? 's' : '' ).'://'."{$_SERVER['HTTP_HOST']}";

	if (!safe_field ('name', 'txp_prefs', "pat_admin_url'"))
		safe_insert('txp_prefs', "prefs_id=1, name='pat_admin_url', val='".$pat_interface."', type=1, event='admin', html='text_input', position=26");

	safe_repair('txp_plugin');
}


/**
 * Delete this plugin prefs.
 *
 */
function _pat_public_bar_cleanup()
{
	
	safe_delete('txp_prefs', "name='pat_admin_url'");
	safe_repair('txp_plugin');
}
