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
}

interface AssetSearchFieldState {
	keywords: string;
	asset: number;
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
		results = results.map( ( result: string ) => {
			return {
				label: result,
				value: result,
			}
		} );
		this.setState( {
			keywords : keywords,
			assets   : [ results[0] ?? { value: null, label: null } ],
		} );
	}
	
	onAssetChange( id: number ) {
		this.setState( { asset: id } );
		this.props.onChange( id );
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
				<div style={ { height: '90px' } }>
					<ComboboxControl
						label="Asset"
						value={ this.state.asset }
						onChange={ ( value: any ) => {
							this.onAssetChange( value );
						} }
						options={ this.state.assets }
						onFilterValueChange={ ( keywords: string ) => {
							this.onKeywordsChange( keywords );
						} }
					/>
				</div>
				<div>
					<span>Available: </span><span><strong>{ this.getAssetsAvailable() }</strong></span>
				</div>
			</div>
		)
	}
}
