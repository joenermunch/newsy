// Import necessary dependencies from WordPress package
import {
	useBlockProps,
	InspectorControls,
	InnerBlocks,
	RichText,
} from "@wordpress/block-editor";
import { PanelBody, PanelRow } from "@wordpress/components";
import { Fragment, useState, useEffect, RawHTML } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import { SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";

//
// Define the Edit component for the custom block
export default function Edit({ attributes, setAttributes }) {
	// Use the useBlockProps hook to get the block props
	const blockProps = useBlockProps();
	const ALLOWED_BLOCKS = ["gravityforms/form"];

	return (
		<div {...blockProps}>
			<div className="cta-container">
				<div className="text-container">
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
				</div>

				<div className="form-container">
					<InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
				</div>
			</div>
		</div>
	);
}
