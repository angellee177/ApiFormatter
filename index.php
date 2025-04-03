<?php

	//Stored in database as..
	$coreg_url = "country;id_campaign;email;firstname;surname;gender;BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__";
	$coreg_url_format_2 = "country;id_campaign;data[email];data[firstname];data[surname];data[gender];BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__";

	//split fields and values and turn them into two arrays
	list($fields_list,$values_list)=explode('##',$coreg_url);
	$fields_array = explode(';',$fields_list);
	$values_array = explode(';',$values_list);

	
	if (count($fields_array)==count($values_array))
	{
		$post_fields_array=array_combine($fields_array,$values_array);
		print_r($post_fields_array);
	}

	/*
		-JSON Format-
		{
			"country": "au",
			"id_campaign": 1401,
			"data":
			{
				"email": "__email__",
				"firstname": "__firstname__",
				"surname": "__lastname__",
				"gender": "__gender__",
			}
			"BirthdateMonth": "__mob__",
			"BirthdateYear": "__yob__",
			"language": "en",
			"subid": 3474234,
			"extrasubid": "__user_id__"
		}
	*/
?>