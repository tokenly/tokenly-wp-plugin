import * as React from 'react';
import { Component } from 'react';

declare const wp: any;

import { 
	// @ts-ignore
	ComboboxControl,
} from '@wordpress/components';

interface AssetSearchFieldProps {
	onChange: any;
	assets: any;
	label?: string;
	help?: string;
}

interface AssetSearchFieldState {
	keywords: string;
	asset: string;
	assets: Array<ComboboxOption>;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export class AssetSearchField extends Component<AssetSearchFieldProps, AssetSearchFieldState> {
	state: AssetSearchFieldState = {
		keywords: null,
		asset: null,
		assets: [],
	};
	constructor( props: AssetSearchFieldProps ) {
		super( props );
		this.onKeywordsChange = this.onKeywordsChange.bind( this );
		this.onAssetChange = this.onAssetChange.bind( this );
		this.getAssetsAvailable = this.getAssetsAvailable.bind( this );
	}
	
	onKeywordsChange( keywords: string ) {
		if ( keywords == '' ) {
			return;
		}
		let results = this.props.assets.filter( ( value: string ) => {
			return value.toLowerCase().indexOf( keywords.toLowerCase() ) >= 0;
		} );
		if ( results?.length > 0 ) {
			results = results.map( ( result: string ) => {
				return {
					label: result,
					value: result,
				}
			} );
			this.setState( {
				assets : [ results[0] ],
			} );
		}
		this.onAssetChange( keywords );
	}
	
	onAssetChange( assetName: string ) {
		this.setState( { 
			asset    : assetName,
			keywords : assetName,
		} );
		this.props.onChange( assetName );
	}

	getAssetsAvailable() {
		if ( this.props.assets?.length > 0 ) {
			return this.props.assets.join( ', ' )
		} else {
			return 'none';
		}
	}

	render() {
		return (
			<div style={ { marginBottom: '12px' } }>
				<div style={ { height: '40px' } }>
					<ComboboxControl
						label={ this.props.label }
						help={ this.props.help }
						value={ this.state.keywords }
						onChange={ ( value: any ) => {
							this.onAssetChange( value );
						} }
						options={ this.state.assets }
						onFilterValueChange={ ( keywords: string ) => {
							this.onKeywordsChange( keywords );
						} }
					/>
				</div>
				{/* <div>
					<span>Available: </span><span><strong>{ this.getAssetsAvailable() }</strong></span>
				</div> */}
			</div>
		)
	}
}
