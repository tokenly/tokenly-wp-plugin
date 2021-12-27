import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import MetaRepositoryInterface from '../../Interfaces/Repositories/Token/MetaRepositoryInterface';
import { TokenMetaData } from '../../Interfaces';
import { TYPES } from '../../Types';
import AttributeRepeater from '../Components/AttributeRepeater';
import eventBus from './../../EventBus';

import { 
	TextControl,
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface MetaEditPageData {
	meta: TokenMetaData;
	extra: any;
}

interface MetaEditPageProps {
	pageData: MetaEditPageData;
}

interface MetaEditPageState {
	storingSource: boolean;
	meta: TokenMetaData;
	postId: number;
}

export default class MetaEditPage extends Component<MetaEditPageProps, MetaEditPageState> {
	@resolve( TYPES.Repositories.Token.MetaRepositoryInterface )
	metaRepository: MetaRepositoryInterface;

	state: MetaEditPageState = {
		storingSource: false,
		meta: {} as any,
		postId: null,
	}
	
	constructor( props: MetaEditPageProps ) {
		super( props );
		const urlParams = new URLSearchParams(window.location.search);
		const postId = parseInt( urlParams.get( 'post' ) );
		this.state.postId = postId;
		this.state.meta = Object.assign( this.state.meta, this.props.pageData.meta );
		this.onAssetUpdated = this.onExtraUpdated.bind( this );
		this.onExtraUpdated = this.onExtraUpdated.bind( this );
		this.onPostUpdate = this.onPostUpdate.bind( this );
	}
	
	onAssetUpdated( value: any ) {
		//
	}
	
	onExtraUpdated( newExtra: any ) {
		let newState = Object.assign( {}, this.state );
		newState.meta.extra = Object.assign( [], newExtra );
		newState.meta.extra = newState.meta.extra.filter( function ( attribute: any ) {
			return attribute != null;
		} );
		this.setState( { ...newState } );
		this.onPostUpdate( newState.meta );
	}

	onPostUpdate( newPostData: any ) {
		eventBus.dispatch( 'postDataUpdated', newPostData );
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
								this.onPostUpdate( state );
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
			</Fragment>
		);
	}
}
