import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';

import icons from './icons';

registerBlockType( 'planist-gutenberg/planist-block', {
	title: 'Planist',
	icon: icons.planist,
	category: 'widgets',
	keyword: [ 'planist', 'event', 'schedule', 'calender' ],
	attributes: {
		url: {
			type: 'string',
			default: '',
		},
	},
	example: {
		attributes: {
			url: 'https://app.planist.fr/mohsen/45m',
		},
	},
	edit: ( props ) => {
		const {
			className,
			attributes: { url },
			setAttributes,
		} = props;

		const onChangeUrl = ( value ) => {
			setAttributes( { url: value } );
		};

		return (
			<div { ...useBlockProps() }>
				<InspectorControls key="setting">
					<div className={ className } style={ { padding: '10px' } }>
						<TextControl
							label="Booking page URL"
							value={ url }
							onChange={ onChangeUrl }
						/>
					</div>
				</InspectorControls>

				<div className="planist-block">
					{ url ? (
						<div>
							{ icons.planist } { url }
						</div>
					) : (
						<div>{ icons.planist } Set booking page URL</div>
					) }
				</div>
			</div>
		);
	},
	save: ( props ) => {
		const {
			className,
			attributes: { url },
		} = props;

		return `[planist url="${ url }"]`;
	},
} );
