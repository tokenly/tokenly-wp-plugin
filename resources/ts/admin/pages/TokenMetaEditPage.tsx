import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TokenMetaRepository, TokenMetaData } from '../../repositories/TokenMetaRepository';

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
	//
}

interface TokenMeta {
	asset: string,
}

interface TokenMetaEditPageProps {
	pageData: TokenMetaEditPageData;
}

interface TokenMetaEditPageState {
	storingSource: boolean;
	tokenMeta: TokenMeta;
	postId: number;
}

export default class TokenMetaEditPage extends Component<TokenMetaEditPageProps, TokenMetaEditPageState> {
	@resolve
	tokenMetaRepository: TokenMetaRepository;

	state: TokenMetaEditPageState = {
		storingSource: false,
		tokenMeta: {
			asset: '',
		},
		postId: null,
	}
	
	constructor( props: TokenMetaEditPageProps ) {
		super( props );
		const urlParams = new URLSearchParams(window.location.search);
		const postId = parseInt( urlParams.get( 'post' ) );
		this.state.postId = postId;
	}

	updateAsset( value: any ) {
		const state = Object.assign( {}, this.state );
		state.tokenMeta.asset = value;
		this.setState( state );
	}

	componentDidMount() {
		this.tokenMetaRepository.show( this.state.postId ).then( ( tokenMeta: TokenMetaData ) => {
			this.setState( {
				tokenMeta: tokenMeta,
			} );
		} );
	}

	render() {
		return (
			<Fragment>
				<Panel header="Additional token meta">
					<PanelBody>
						<PanelRow>
							<div style={{width: '100%'}}>
								<TextControl
									value={this.state.tokenMeta.asset}
									label="Asset"
									onChange={( value: any ) => {
										this.updateAsset( value );
									}}
									style={{width: '100%', maxWidth: '500px', marginBottom: '8px'}}
								/>
								<div style={{opacity: 0.8}}>Is used for pairing meta with an asset</div>
							</div>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Fragment>
		);
	}
}
