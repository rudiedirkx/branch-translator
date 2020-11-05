<?php

return [
	'version' => 1,
	'tables' => [
		'sources' => [
			'id' => ['pk' => true],
			'parent_source_id' => ['unsigned' => true, 'references' => ['sources', 'id']],
			'source',
		],
		'translations' => [
			'id' => ['pk' => true],
			'source_id' => ['unsigned' => true, 'references' => ['sources', 'id', 'cascade']],
			'translation',
		],
	],
	'data' => [
		'sources' => [
			['id' => 1, 'parent_source_id' => null, 'source' => "Hi Sarah."],
			['id' => 2, 'parent_source_id' => 1, 'source' => "Kenny!"],
			['id' => 3, 'parent_source_id' => 2, 'source' => "Come with me, quickly!"],
			['id' => 4, 'parent_source_id' => 3, 'source' => "Eeh, okay..."],
			['id' => 5, 'parent_source_id' => 4, 'source' => "Yess! Let's go upstairs. This way.."],
			['id' => 6, 'parent_source_id' => 3, 'source' => "No, I can't right now, Sarah."],
			['id' => 7, 'parent_source_id' => 6, 'source' => "Aaw, I thought you liked me..."],
			['id' => 8, 'parent_source_id' => 7, 'source' => "I do!, but I really have to talk to Jeff first."],
			['id' => 10, 'parent_source_id' => 8, 'source' => "Sorry, really gotta run. Bye."],
			['id' => 11, 'parent_source_id' => 10, 'source' => "I'll be right back, promise, byyee."],
			['id' => 9, 'parent_source_id' => 7, 'source' => "What ever made you think that?"],
			['id' => 12, 'parent_source_id' => 9, 'source' => "You're like an annoying little sister."],
		],
		'translations' => [
			['id' => 1, 'source_id' => 1, 'translation' => "Hoi Sarah."],
		],
	],
];
