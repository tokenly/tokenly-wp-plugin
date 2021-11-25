import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TokenMetaRepositoryInterface } from '../../Interfaces/Repositories/TokenMetaRepositoryInterface';
import { TokenMetaData } from '../../Interfaces';
import { TYPES } from '../../Types';
import { AttributeRepeater } from '../Components/AttributeRepeater';

import { 
	TextControl,
	TextareaControl,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface TokenMetaEditPageData {
	meta: TokenMetaData;
	extra: any;
}

interface TokenMetaEditPageProps {
	pageData: TokenMetaEditPageData;
}

interface TokenMetaEditPageState {
	storingSource: boolean;
	meta: TokenMetaData;
	postId: number;
}

export default class TokenMetaEditPage extends Component<TokenMetaEditPageProps, TokenMetaEditPageState> {
	@resolve( TYPES.TokenMetaRepositoryInterface )
	tokenMetaRepository: TokenMetaRepositoryInterface;

	state: TokenMetaEditPageState = {
		storingSource: false,
		meta: {} as any,
		postId: null,
	}
	
	constructor( props: TokenMetaEditPageProps ) {
		super( props );
		const urlParams = new URLSearchParams(window.location.search);
		const postId = parseInt( urlParams.get( 'post' ) );
		this.state.postId = postId;
		this.state.meta = Object.assign( this.state.meta, this.props.pageData.meta );
		this.onExtraUpdated = this.onExtraUpdated.bind( this );
		console.log(this.props.pageData);
	}
	
	onExtraUpdated( newExtra: any ) {
		let newState = Object.assign( {}, this.state );
		newState.meta.extra = Object.assign( [], newExtra );
		newState.meta.extra = newState.meta.extra.filter( function ( attribute: any ) {
			return attribute != null;
		} );
		this.setState( { ...newState } );
	}

	render() {
		return (
			<Fragment>
				<PanelRow>
					<div style={{width: '100%', marginTop: '12px'}}>
						<TextControl
							value={this.state.meta.asset}
							label="Asset"
							help="Is used for pairing meta with an asset"
							onChange={( value: any ) => {
								const state = Object.assign( {}, this.state.meta );
								state.asset = value;
								this.setState( { meta: state } );
							}}
							style={{width: '100%', maxWidth: '500px', marginBottom: '8px'}}
						/>
						<AttributeRepeater
							label="Extra attributes"
							help="Additional key-value asset meta attributes. They are displayed in the more info sections."
							attributes={ this.props.pageData?.meta?.extra }
							onUpdate={ this.onExtraUpdated }
						/>
					</div>
				</PanelRow>
				<input type="hidden" name="tokenly_data" value={ JSON.stringify( this.state.meta as any ) } />
			</Fragment>
		);
	}
}
