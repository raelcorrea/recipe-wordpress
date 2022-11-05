/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';
import apiFetch from '@wordpress/api-fetch';


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
const categoryList = [];

export default function Edit({attributes,setAttributes}) {

	const categoryListTemplateStr = function({name,id}){
		let list = attributes.categoriesSelectedList
		return (<div className="itemCategory" data-id={id}>
			<p>{name}</p>
			<input type="checkbox" data-id={id} value={id} onChange={(value)=>{list.push({name,value}); setAttributes({categoriesSelectedList:list}) }} />
		</div>)
	}
	
	if(attributes.categoryList.length == 0){
		apiFetch( { path: '/wp/v2/categories' } ).then( ( categories ) => {
			setAttributes({ categoryList: categories });
		});
	}
	return (
		<div className="categoriesSection">
			<RichText 
				{...useBlockProps()}
				tagName="h2"
				value={ attributes.title }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
				onChange={ ( title ) => setAttributes( { title } ) }
				placeholder={ __( 'Título...' ) }
			/>
			<RichText 
				{...useBlockProps()}
				tagName="p"
				value={ attributes.content }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
				onChange={ ( content ) => setAttributes( { content } ) }
				placeholder={ __( 'Conteudo...' ) }
			/>
			<ul className="categoryList">
				{
					attributes.categoryList.map((category,index)=> <li key={index}>{categoryListTemplateStr(category)}</li>)
				}
			</ul>
		</div>
	);
}
