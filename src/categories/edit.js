/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";
import { useEffect, useState } from "@wordpress/element";
import { RichText, InspectorControls } from "@wordpress/block-editor";
import { Panel, PanelBody, PanelRow, Button } from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const categories = useSelect((select) => {
		return select("core").getEntityRecords("taxonomy", "category", {
			per_page: -1,
		});
	}, []);

	return (
		<div {...blockProps}>
			<div className="categories-container">
				<RichText
					tagName="h2"
					placeholder="Your Title"
					value={attributes.title}
					onChange={(title) => setAttributes({ title })}
				/>
				<RichText
					tagName="p"
					placeholder="Your subtitle"
					value={attributes.subtitle}
					onChange={(subtitle) => setAttributes({ subtitle })}
				/>

				{!categories && "Loading"}
				{categories && categories.length === 0 && "No Categories"}
				{categories && categories.length > 0 && (
					<ul>
						{categories.map((category) => (
							<li
								key={category.id}
								style={{ backgroundColor: category.meta.category_color }}
							>
								<a href={category.link}>{category.name}</a>
							</li>
						))}
					</ul>
				)}
			</div>
		</div>
	);
}
