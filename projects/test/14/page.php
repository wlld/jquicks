<?php
if(isset($_GET['topic'])) jq::get('mm')->params['subject'] = (integer)$_GET['topic'];