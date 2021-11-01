import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TokenMetaRepository } from '../../repositories/TokenMetaRepository';
import { TokenMetaData } from '../../interfaces';

import { 
	TextControl,
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

import { 
	Fragment,
} from '@wordpress/element';

interface TokenMetaEditPageData {
	meta: TokenMetaData;
}

interface TokenMetaEditPageProps {
	pageData: TokenMetaEditPageData;
}

interface TokenMetaEditPageState {
	storingSource: boolean;
	meta: TokenMetaData;
	postId: number;
}

declare const wp: any;


export default class TokenMetaEditPage extends Component<TokenMetaEditPageProps, TokenMetaEditPageState> {
	@resolve
	tokenMetaRepository: TokenMetaRepository;

	state: TokenMetaEditPageState = {
		storingSource: false,
		meta: {} as any,
		postId: null,
	}
	
	constructor( props: TokenMetaEditPageProps ) {
		super( props );
		console.log(this.props.pageData);
		const urlParams = new URLSearchParams(window.location.search);
		const postId = parseInt( urlParams.get( 'post' ) );
		this.state.postId = postId;
		this.state.meta = Object.assign( this.state.meta, this.props.pageData.meta );
	}

	render() {
		return (
			<Fragment>
				<Panel header="Additional token meta">
					<PanelBody>
						<PanelRow>
							<div style={{width: '100%'}}>
								<TextControl
									value={this.state.meta.asset}
									label="Asset"
									onChange={( value: any ) => {
										const state = Object.assign( {}, this.state.meta );
										state.asset = value;
										this.setState( { meta: state } );
									}}
									style={{width: '100%', maxWidth: '500px', marginBottom: '8px'}}
								/>
								<div style={{opacity: 0.8}}>Is used for pairing meta with an asset</div>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
				<input type="hidden" name="tokenly_data" value={ JSON.stringify( this.state.meta as any ) } />
			</Fragment>
		);
	}
}
