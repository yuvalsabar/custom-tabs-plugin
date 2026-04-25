/* Custom Tabs Plugin — accessible tab widget */
(function () {
	'use strict';

	function initTabsWidget(container) {
		var tablist = container.querySelector('[role="tablist"]');
		var tabs    = Array.from(container.querySelectorAll('[role="tab"]'));
		var panels  = Array.from(container.querySelectorAll('[role="tabpanel"]'));

		if (!tablist || !tabs.length) return;

		function activateTab(tab) {
			tabs.forEach(function (t) {
				t.setAttribute('aria-selected', 'false');
				t.setAttribute('tabindex', '-1');
				t.classList.remove('ct-tabs__tab--active');
			});

			panels.forEach(function (p) {
				p.setAttribute('hidden', '');
				p.classList.remove('ct-tabs__panel--active');
			});

			tab.setAttribute('aria-selected', 'true');
			tab.setAttribute('tabindex', '0');
			tab.classList.add('ct-tabs__tab--active');

			var panel = document.getElementById(tab.getAttribute('aria-controls'));
			if (panel) {
				panel.removeAttribute('hidden');
				panel.classList.add('ct-tabs__panel--active');
			}
		}

		tablist.addEventListener('keydown', function (e) {
			var idx = tabs.indexOf(document.activeElement);
			if (idx === -1) return;

			var next;
			switch (e.key) {
				case 'ArrowRight':
					next = (idx + 1) % tabs.length;
					break;
				case 'ArrowLeft':
					next = (idx - 1 + tabs.length) % tabs.length;
					break;
				case 'Home':
					next = 0;
					break;
				case 'End':
					next = tabs.length - 1;
					break;
				default:
					return;
			}

			e.preventDefault();
			tabs[next].focus();
			activateTab(tabs[next]);
		});

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				activateTab(tab);
			});
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.ct-tabs').forEach(initTabsWidget);
	});
})();
