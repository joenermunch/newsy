(function (blocks, element, components, i18n) {
	var el = element.createElement;
	var __ = i18n.__;

	blocks.registerBlockType("my-plugin/category-list", {
		title: "Category List",
		icon: "list-view",
		category: "widgets",
		edit: function (props) {
			var categories = wp.data
				.select("core")
				.getEntityRecords("taxonomy", "category", { per_page: -1 });
			if (categories !== null) {
				var categoryList = categories.map(function (category) {
					return el("li", { key: category.id }, category.name);
				});
			} else {
				var categoryList = "No categories found";
			}
			return el("ul", null, categoryList);
		},
		save: function (props) {
			var categories = wp.data
				.select("core")
				.getEntityRecords("taxonomy", "category", { per_page: -1 });
			if (categories !== null) {
				var categoryList = categories.map(function (category) {
					return el("li", { key: category.id }, category.name);
				});
			} else {
				var categoryList = "No categories found";
			}
			return el("ul", null, categoryList);
		},
	});
})(window.wp.blocks, window.wp.element, window.wp.components, window.wp.i18n);
