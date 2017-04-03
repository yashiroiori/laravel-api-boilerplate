<?php

return [

	/*
	|--------------------------------------------------------------------------
	| API Docs Profiles
	|--------------------------------------------------------------------------
	|
	| Different possible profiles used for documentation generation based on samples.
	|
	| Each profile is defined with :
	|
	| - defaultRoutePrefix :    Used for routing and added at the end of the computed output base (e.g. public/docs/developer/v1)
	| - outputPathBase :        Base of the directory where to generate the documentation (e.g. public/docs/developer)
	| - actAsUserId :           User ID used to fake Api access with generator
	| - bindings :              Bindings used to generate samples responses in documentation
	| - routes :                Routes used to generate documentation
	|
	| @see SamplesSeeder
	| @see App\Console\Commands\GenerateApiDocs
	|
	*/
	'profiles' => [

		'Developer' => [

			'defaultRoutePrefix' => 'v1',
			'outputPathBase' => realpath(base_path('public/docs/developer')),
			'actAsUserId' => '41abdec2-1389-11e7-93ae-92361f002671',
			'bindings' => [

				// John Smith Sample Project 1'
				'projectId' => '1bcc7efc-138c-11e7-93ae-92361f002671',

				// John Smith
				'userId' => '605c7610-1389-11e7-93ae-92361f002671',

				// Algolia
				'search_engine_id' => 'ee87e3b2-1388-11e7-93ae-92361f002671',

				// Owner
				'user_role_id' => 'Owner',

				// en_US
				'i18nLangId' => 'en_US',

				// Algolia
				'searchEngineId' => 'ee87e3b2-1388-11e7-93ae-92361f002671',

			],
			'routes' => [

				'me.index',

				'user.index',
				'user.show',
				'user.store',

				'userProject.index',
				'userProject.show',

				'project.index',
				'project.show',
				'project.store',
				'project.update',

				'userHasProject.index',
				'userHasProject.show',
				'userHasProject.store',
				'userHasProject.update',
				'userHasProject.destroy',

				'i18nLang.index',
				'i18nLang.show',
				'i18nLang.store',
				'i18nLang.update',

				'searchEngine.index',
				'searchEngine.show',
				'searchEngine.store',
				'searchEngine.update',

			]

		],

		/*
		'Support' => [

			// @todo ?

		],
		*/

		'End-User' => [

			'defaultRoutePrefix' => 'v1',
			'outputPathBase' => realpath(base_path('public/docs/end-user')),
			'actAsUserId' => '605c7610-1389-11e7-93ae-92361f002671',
			'bindings' => [

				// John Smith Sample Project 1'
				'projectId' => '1bcc7efc-138c-11e7-93ae-92361f002671',

				// John Smith
				'userId' => '605c7610-1389-11e7-93ae-92361f002671',

				// Algolia
				'search_engine_id' => 'ee87e3b2-1388-11e7-93ae-92361f002671',

				// Owner
				'user_role_id' => 'Owner',

				// en_US
				'i18nLangId' => 'en_US',

			],
			'routes' => [

				'me.index',

				'userProject.index',
				'userProject.show',

				'project.show',
				'project.store',
				'project.update',

				'i18nLang.index',
				'i18nLang.show',

			]

		],

	]

];
