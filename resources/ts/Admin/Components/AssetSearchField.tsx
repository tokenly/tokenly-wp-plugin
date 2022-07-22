import * as React from 'react'
import { Fragment } from 'react'
import { useState } from 'react'

import { 
	// @ts-ignore
	TextControl,
} from '@wordpress/components'
import Autocomplete from './Autocomplete'

interface AssetSearchFieldProps {
	onChange: any
	asset: any
	assets: any
	label?: string
	help?: string
	inputProps?: any
	disabled?: boolean
}

export default function AssetSearchField( props: AssetSearchFieldProps ) {
	const [ keywords, setKeywords ] = useState( '' )
	const [ options, setOptions ] = useState( [] )
	const [ focused, setFocused ] = useState<boolean>( false )

	function onKeywordsChange( newKeywords: string ) {
		props.onChange( newKeywords )
		setKeywords( newKeywords )
		setOptions( getAssetOptions() )
	}

	function getAssetName( asset: any ) {
		let assetName = asset.asset.address
		if ( asset.asset.index ) {
			assetName = `${assetName}:${asset.asset.index}`
		}
		return assetName
	}

	function getAssetOptions() {
		if ( !props.assets || !Array.isArray( props.assets ) || keywords == '' ) {
			return []
		}
		const keywordsFormatted = keywords.toLowerCase()
		const assetsFiltered = props.assets.filter( ( asset: any ) => {
			let assetName = getAssetName( asset )
			return assetName.toLowerCase().indexOf( keywordsFormatted ) >= 0
		} )
		const optionsFiltered = assetsFiltered.map( ( asset ) => {
			const name = getAssetName( asset )
			return {
				label: name,
				value: name,
			}
		} )
		if ( optionsFiltered.length > 1 ) {
			optionsFiltered.length = 1
		}
		return optionsFiltered
	}

	return (
		<div className="tokenly-search">
			<input type="text" { ...props.inputProps } style={ { height: '0px', minHeight: '0px', opacity: 0 } } value={ props.asset } />
			<TextControl
				label={ props.label }
				value={ props.asset }
				onChange={ onKeywordsChange }
				onFocus={ () => {
					setFocused( true )
				} }
				onBlur={ ( event: any ) => {
					setFocused( false )
				} }
			/>
		{ ( focused && options.length > 0 ) &&
			<Autocomplete options={ options } onChange={ onKeywordsChange } />
		}
		</div>
	)
}
