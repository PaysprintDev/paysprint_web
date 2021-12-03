'use strict';
var notify = $.notify('<i class="fa fa-bell-o"></i><strong>Loading page</strong>...', {
	type: 'theme',
	allow_dismiss: true,
	delay: 1000,
	showProgressbar: true,
	timer: 300
});

// setTimeout(function() {
// 	notify.update('message', '<i class="fa fa-bell-o"></i><strong>Hey!</strong>.');
// }, 1000);
