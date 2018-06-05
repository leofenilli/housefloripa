<?php
/**
* @package   Warp Theme Framework
* @author    Elartica Team http://www.elartica.com
* @copyright Copyright (C) Elartica Team
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

global $comments, $comment;

// init vars
$number   = (int) max(isset($widget->params['number']) ? $widget->params['number'] : 5, 1);
$comments = get_comments(array('number' => $number, 'status' => 'approve'));

if ($comments) : ?>
<ul class="uk-comment-list">

    <?php foreach ((array) $comments as $comment) : ?>
    <li>

        <article class="uk-comment">

            <header class="uk-comment-header uk-clearfix">

                <?php echo get_avatar($comment, $size='50', null, 'Avatar'); ?>

                <h4 class="uk-comment-title">
                    <?php echo get_comment_author_link(); ?>
                </h4>

                <p class="uk-comment-meta">
                    <time datetime="<?php echo get_comment_date('Y-m-d'); ?>"><?php comment_date(); ?></time>
                    | <a class="permalink" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">#</a>
                </p>

            </header>

            <div class="uk-comment-body">
                <?php
                    $comment_text = get_comment_text();

                    $txt = strip_tags($comment_text);
                    $limit = 100;
                    $len=strlen($txt);

                    if ($len <= $limit) echo $txt;
                    else
                    {
                        $txt = substr($txt,0,$limit);
                        $pos = strrpos($txt," ");
                        if($pos >0)
                        {
                            $txt = substr($txt,0,$pos);
                            if (($tpos =strrpos($txt,"<")) >  strrpos($txt,">") && $tpos>0)
                            {
                                $txt = substr($txt,0,$tpos-1);
                            }
                        }
                        echo $txt . "...";
                    }
                ?>
            </div>

        </article>

    </li>
    <?php endforeach; ?>

</ul>
<?php endif;
