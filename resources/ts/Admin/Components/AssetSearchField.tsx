import * as React from 'react';
import { Component } from 'react';

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

interface AssetSearchFieldState {
	keywords: string;
	options: Array<any>,
}

interface ComboboxOption {
	value: string,
	label: string,
}

export default class AssetSearchField extends Component<AssetSearchFieldProps, AssetSearchFieldState> {
	state: AssetSearchFieldState = {
		keywords: '',
		options: [],
	};
	constructor( props: AssetSearchFieldProps ) {
		super( props );
		this.onKeywordsChange = this.onKeywordsChange.bind( this );
		this.getAssetOptions = this.getAssetOptions.bind( this );
	}
	
	onKeywordsChange( keywords: string ) {
		if ( keywords == '' && this.props.asset ) {
			keywords = this.props.asset;
		}
		this.setState( { keywords: keywords } );
	}

	getAssetOptions(): any {
		if ( !this.props.assets || !Array.isArray( this.props.assets ) || this.state.keywords == '' ) {
			return [];
		}
		const keywords = this.state.keywords.toLowerCase();
		const assetsFiltered = this.props.assets.filter( ( asset: any ) => {
			return asset.asset.toLowerCase().indexOf( keywords ) >= 0;
		} );
		const options = assetsFiltered.map( ( asset ) => {
			return {
				label: asset.asset,
				value: asset.asset,
			}
		} )
		if ( options.length > 1 ) {
			options.length = 1;
		}
		return options;
	}

	render() {
		return (
			<div style={ { marginBottom: '12px' } }>
				<div style={ { height: '40px' } }>
					<ComboboxControl
						label={ this.props.label }
						value={ this.props.asset }
						onChange={ this.props.onChange }
						options={ this.getAssetOptions() }
						onFilterValueChange={ this.onKeywordsChange }
					/>
				</div>
			</div>
		)
	}
}
