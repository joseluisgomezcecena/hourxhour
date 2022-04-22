<?php


function show_alert($title, $message, $back_url)
{
	echo '<div class="alert alert_primary" style="text-align: center;">';
	echo '<strong class="uppercase"><bdi>';
	echo $title;
	echo '	</bdi>';
	echo '	<br> ' . $message . ' <br>';
	echo '</strong>';
    if($back_url != null){
        echo '<a type="button" href="' . $back_url . '" class="btn btn_secondary uppercase my-5">Go back</a>';
    }
	echo '</div>';
}


function show_alert_noplan($back_url)
{
	show_alert('No plan loaded!', "There isn't an active production plan for this machine/point. ", $back_url);
}
