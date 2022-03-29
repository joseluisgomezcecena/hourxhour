<?php

function dateFormat($format='m-d-Y', $Date=null)
{
	return date($format, strtotime($Date));
}

