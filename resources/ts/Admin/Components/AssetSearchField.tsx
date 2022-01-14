import * as React from 'react';
import { useState } from 'react';

import { 
	// @ts-ignore
	ComboboxControl,
} from '@wordpress/components';

interface AssetSearchFieldProps {
	onChange: any;
	asset: any;
	assets: any;
	label?: string;
	help?: string;
}

export default function AssetSearchField( props: AssetSearchFieldProps ) {
	const [ keywords, setKeywords ] = useState( '' );
	const [ options, setOptions ] = useState( [] );
	
	function onKeywordsChange( newKeywords: string ) {
		if ( newKeywords == '' && props.asset ) {
			newKeywords = props.asset;
		}
		setKeywords( newKeywords );
		setOptions( getAssetOptions() );
	}

	function getAssetOptions() {
		if ( !props.assets || !Array.isArray( props.assets ) || keywords == '' ) {
			return [];
		}
		const keywordsFormatted = keywords.toLowerCase();
		const assetsFiltered = props.assets.filter( ( asset: any ) => {
			return asset.asset.toLowerCase().indexOf( keywordsFormatted ) >= 0;
		} );
		const optionsFiltered = assetsFiltered.map( ( asset ) => {
			return {
				label: asset.asset,
				value: asset.asset,
			}
		} )
		if ( optionsFiltered.length > 1 ) {
			optionsFiltered.length = 1;
		}
		return optionsFiltered;
	}

	return (
		<div style={ { marginBottom: '12px' } }>
			<div style={ { height: '40px' } }>
				<ComboboxControl
					label={ props.label }
					value={ props.asset }
					onChange={ props.onChange }
					options={ options }
					onFilterValueChange={ onKeywordsChange }
				/>
			</div>
		</div>
	)
}
