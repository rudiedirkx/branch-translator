<?php

return [
	'version' => 2,
	'tables' => [
		'projects' => [
			'id' => ['pk' => true],
			'name',
		],
		'sources' => [
			'id' => ['pk' => true],
			'project_id' => ['unsigned' => true, 'references' => ['projects', 'id']],
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
		'projects' => [
			[
				'id' => 1,
				'name' => "Sarah & Kenny",
			],
		],
		'sources' => [
			[
				'project_id' => 1,
				'id' => 1,
				'parent_source_id' => null,
				'source' => "Hi Sarah.",
			],
			[
				'project_id' => 1,
				'id' => 2,
				'parent_source_id' => 1,
				'source' => "Kenny!",
			],
			[
				'project_id' => 1,
				'id' => 3,
				'parent_source_id' => 2,
				'source' => "Come with me, quickly!",
			],
			[
				'project_id' => 1,
				'id' => 4,
				'parent_source_id' => 3,
				'source' => "Eeh, okay...",
			],
			[
				'project_id' => 1,
				'id' => 5,
				'parent_source_id' => 4,
				'source' => "Yess! Let's go upstairs. This way..",
			],
			[
				'project_id' => 1,
				'id' => 6,
				'parent_source_id' => 3,
				'source' => "No, I can't right now, Sarah.",
			],
			[
				'project_id' => 1,
				'id' => 7,
				'parent_source_id' => 6,
				'source' => "Aaw, I thought you liked me...",
			],
			[
				'project_id' => 1,
				'id' => 8,
				'parent_source_id' => 7,
				'source' => "I do!, but I really have to talk to Jeff first.",
			],
			[
				'project_id' => 1,
				'id' => 10,
				'parent_source_id' => 8,
				'source' => "Sorry, really gotta run. Bye.",
			],
			[
				'project_id' => 1,
				'id' => 11,
				'parent_source_id' => 10,
				'source' => "I'll be right back, promise, byyee.",
			],
			[
				'project_id' => 1,
				'id' => 9,
				'parent_source_id' => 7,
				'source' => "What ever made you think that?",
			],
			[
				'project_id' => 1,
				'id' => 12,
				'parent_source_id' => 9,
				'source' => "You're like an annoying little sister.",
			],
		],
		'translations' => [
			[
				'id' => 1,
				'source_id' => 1,
				'translation' => "Hoi Sarah.",
			],
		],
	],
];
