// Import necessary dependencies from WordPress package
import { FormTokenField } from "@wordpress/components";
import {
	useBlockProps,
	InspectorControls,
	RichText,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { useState } from "@wordpress/element";
import { PanelBody, PanelRow } from "@wordpress/components";

// Define the Edit component for the custom block
export default function Edit({ attributes, setAttributes }) {
	// Use the useBlockProps hook to get the block props
	const blockProps = useBlockProps();

	// Set the state for the selected posts
	const [selectedPosts, setSelectedPosts] = useState(attributes.posts || []);

	// Use the useSelect hook to get the posts from the WordPress API
	let { posts, pages } = useSelect((select) => {
		const { getPostTypes } = select("core");

		const postList = select("core").getEntityRecords("postType", "post", {
			_embed: true,
		});

		const pageList = select("core").getEntityRecords("postType", "page", {
			_embed: true,
		});

		return {
			posts: postList,
			pages: pageList,
		};
	}, []);

	let options = [];

	if (posts && pages) {
		posts = posts.concat(pages);

		options = posts.map((post) => post.title.rendered);
	}

	// Define the function to update the selected posts
	const updatePosts = (tokens) => {
		// Map the tokens to post objects
		const newPosts = tokens.map((token) => {
			const matchingPost = posts.find((post) => post.title.rendered === token);

			return {
				id: matchingPost?.id,
				link: matchingPost?.link,
				title: matchingPost?.title.rendered,
				image: matchingPost?._embedded["wp:featuredmedia"]
					? matchingPost?._embedded["wp:featuredmedia"][0].source_url
					: "",
				category: matchingPost?._embedded["wp:term"]
					? matchingPost?._embedded["wp:term"][0].name
					: "",
				excerpt: matchingPost?.excerpt.rendered,
			};
		});

		// Update the state of the selected posts and the block attributes
		setSelectedPosts(newPosts);
		setAttributes({ posts: newPosts });
	};

	// Return the JSX for the Edit component
	return (
		<>
			{/* Add an inspector panel for post options */}
			<InspectorControls>
				<PanelBody title="Post Options">
					<PanelRow>
						{/* Add a FormTokenField to select the posts */}
						<FormTokenField
							value={selectedPosts.map((post) => post.title)}
							suggestions={options}
							onChange={updatePosts}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			{/* Add the block props to the container */}
			<div {...blockProps}>
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
				{/* Display a loading message if posts are not yet loaded */}
				{!posts && "Loading"}
				{/* Display a message if there are no posts */}
				{selectedPosts.length === 0 && "Select a post"}
				{/* Display a message if there are no posts */}
				{posts && posts.length === 0 && "No posts"}
				{/* Display the selected posts */}
				{selectedPosts && selectedPosts.length > 0 && (
					<div className="post-list-container">
						<ul>
							{/* Map over the selected posts and display each one */}
							{selectedPosts.map((post) => {
								return (
									<li className="post-item-secondary" key={post.id}>
										<a href={post.link}>
											<div className="text-container">
												<h2>{post.title}</h2>
												<p>{post.excerpt}</p>
											</div>
										</a>
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
