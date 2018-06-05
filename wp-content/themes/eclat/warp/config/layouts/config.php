<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get config
$config = $this['config'];

// get config xml
$xml = $this['dom']->create($this['path']->path('theme:config.xml'), 'xml');

// render nav & main
$nav  = array();
$main = array();

foreach ($xml->find('fields') as $fields) {

	// init vars
    $name    = $fields->attr('name');
    $icon    = $fields->attr('icon');

    $content = $this->render('config:layouts/fields', array('config' => $config, 'fields' => $fields, 'values' => $config, 'prefix' => '', 'attr' => array()));

	$nav[]  = sprintf('<li><a href=""><i class="%s"></i> %s</a></li>', $icon, $name);
	$main[] = sprintf('<div class="uk-form tm-form"><h1 class="uk-article-title">%s</h1>%s</div>', $name, $content);
}

?>
<div>
    <div>
        <?php if ($messages = $this->get('messages')) { ?>
        <div>
            <h2 style="display: none"></h2>
            <?php
            //echo implode("<br>", $messages);
            $messages_num = 0;
            foreach($messages as $message){
                $messages_num++;
                echo '<div id="setting-error-theme'.$messages_num.'" class="updated settings-error notice is-dismissible"><p>'.$message.'</p>
            <button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
            }
            ?>
        </div>
        <?php } else { ?>
        <div>
            <h2 style="display: none"></h2>
        </div>
        <?php } ?>
    </div>
</div>
<div id="config" class="warp">

	<div class="tm-content">

		<div class="tm-sidebar">

			<div class="tm-sidebar-logo uk-panel">
				<img width="140" height="46" src="<?php echo $this['path']->url('config:images/logo.svg'); ?>" alt="">
			</div>

			<div class="uk-panel">
				<ul class="uk-nav uk-nav-side">
					<?php echo implode("\n", $nav); ?>
				</ul>
			</div>

		</div>

		<main class="tm-main">
			<?php echo implode("\n", $main); ?>
		</main>

	</div>

</div>
