export default [
	{
		path : '/home',
		name : 'home',
		component : require('./components/dashboard/home.vue'),
		alias : '/',
		meta : {
			breadcrumbIconClass : 'fa fa-home',
		}
	},
	{
		path : '/api-configuration',
		name : 'api-configuration',
		component : require('./components/dashboard/api-configuration.vue'),
		props : true,
		meta : {
			breadcrumbIconClass : 'fa fa-cubes',
			parentRouteName : 'home',
		}
	},
	{
		path : '/i18n-langs',
		name : 'i18n-langs',
		component : require('./components/dashboard/i18n-langs.vue'),
		meta : {
			breadcrumbIconClass : 'fa fa-language',
			parentRouteName : 'home',
		}
	},
	{
		path : '/i18n-lang/:i18nLangId',
		name : 'i18n-lang',
		component : require('./components/dashboard/i18n-lang.vue'),
		props : true,
		meta : {
			breadcrumbIconClass : 'fa fa-language',
			parentRouteName : 'i18n-langs',
		}
	},
	{
		path : '/users',
		name : 'users',
		component : require('./components/dashboard/users.vue'),
		meta : {
			breadcrumbIconClass : 'fa fa-user',
			parentRouteName : 'home',
		}
	},
	{
		path : '/user/:userId',
		name : 'user',
		component : require('./components/dashboard/user.vue'),
		props : true,
		meta : {
			breadcrumbIconClass : 'fa fa-user',
			parentRouteName : 'users',
		}
	},
	{
		path : '/user-groups',
		name : 'user-groups',
		component : require('./components/dashboard/user-groups.vue'),
		meta : {
			breadcrumbIconClass : 'fa fa-users',
			parentRouteName : 'home',
		}
	},
	{
		path : '/user-group/:userGroupId',
		name : 'user-group',
		component : require('./components/dashboard/user-group.vue'),
		props : true,
		meta : {
			breadcrumbIconClass : 'fa fa-users',
			parentRouteName : 'user-groups',
		}
	},
	{
		path : '/test',
		name : 'test',
		component : require('./components/dashboard/test.vue'),
		alias : '/',
		meta : {
			breadcrumbIconClass : 'fa fa-thumbs-o-down',
		}
	}
];