<?php

	//Stored in database as..
	$coreg_url = "country;id_campaign;email;firstname;surname;gender;BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__";
	$coreg_url_format_2 = "country;id_campaign;data[email];data[firstname];data[surname];data[gender];BirthdateMonth;BirthdateYear;language;subid;extrasubid##au;1401;__email__;__firstname__;__lastname__;__gender__;__mob__;__yob__;en;3474234;__user_id__";

	//split fields and values and turn them into two arrays
	list($fields_list,$values_list)=explode('##',$coreg_url);
	$fields_array = explode(';',$fields_list);
	$values_array = explode(';',$values_list);

	/**
	 * Goal: handle different API input format i.e $coreg_url and $coreg_url_format_2
	 * 1. create function to accept params called convertAPIFormatToJson(apiFormat: String) {}
	 * 2. create a class with the constructor to handle both of $coreg_url and $coreg_url_format_2
	 * 3. create input validation, to check if the given input are matches the step 3.
	 * 4. if not matches, then put into logger, (can write into new file or use console.log)
	 * 5. the function output is JSON format, means in object
	 */

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