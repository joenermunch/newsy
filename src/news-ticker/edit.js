// Import necessary dependencies from WordPress package
import { FormTokenField } from "@wordpress/components";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { useState } from "@wordpress/element";
import { PanelBody, PanelRow } from "@wordpress/components";

// Define the Edit component for the custom block
export default function Edit({ attributes, setAttributes }) {
	// Use the useBlockProps hook to get the block props
	const blockProps = useBlockProps();

	// Set the state for the selected posts
	const [selectedPosts, setSelectedPosts] = useState([]);

	// Use the useSelect hook to get the posts from the WordPress API
	const { posts } = useSelect((select) => {
		return {
			posts: select("core").getEntityRecords("postType", "post", {
				_embed: true,
				per_page: 10,
			}),
		};
	}, []);

	// Create an array of post titles to use as options for the FormTokenField

	// Return the JSX for the Edit component
	return (
		<>
			<div {...blockProps}>
				{/* Display a loading message if posts are not yet loaded */}
				{!posts && "Loading"}
				{/* Display a message if there are no posts */}
				{posts && posts.length === 0 && "No posts found"}
				{/* Display the selected posts */}
				{posts && posts.length > 0 && (
					<div className="news-ticker-container" id="ticker">
						<ul>
							{/* Map over the selected posts and display each one */}
							{posts.map((post) => {
								return (
									<li className="ticker-item" key={post.id}>
										<a href={post.link}>{post.title.rendered}</a>
									</li>
								);
							})}
						</ul>
					</div>
				)}
			</div>
		</>
	);
}
