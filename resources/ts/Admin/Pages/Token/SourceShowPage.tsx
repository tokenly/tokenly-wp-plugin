import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface SourceShowPageData {
	//
}

interface SourceShowPageProps {
	pageData: SourceShowPageData;
}

interface SourceShowPageState {
	sourceId: string,
	source: any,
	loading: boolean,
}

export default class SourceShowPage extends Component<SourceShowPageProps, SourceShowPageState> {
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;

	state: SourceShowPageState = {
		sourceId: null,
		source: null,
		loading: false,
	}
	constructor( props: SourceShowPageProps ) {
		super( props );
		this.getAssetNames = this.getAssetNames.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.sourceId = urlParams.get( 'source' );
	}

	getAssetNames() {
		let balances = this.state?.source?.address?.balances;
		if ( !balances ) {
			return;
		}
		let assets = [] as any;
		Object.keys( balances ).map( ( key, index ) => {
			assets.push( balances[ key ].asset );
		} );
		assets = assets.join( ', ' );
		return assets;
	}

	isSourceValid() {
		return ( this.state.source && typeof this.state.source === 'object' );
	}

	componentWillMount() {
		this.setState( { loading: true } );
		const params = {
			with: ['address'],
		}
		this.sourceRepository.show( this.state.sourceId, params ).then( ( source: any ) => {
			console.log(source);
			this.setState( {
				loading: false,
				source: source,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={ 'Source details' }>
				<Panel header={ this.state.source?.address.label }>
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.loading
								?	<Flex justify="flex-start">
										<span>Loading source ... </span>
										<Spinner />
									</Flex>
								:	<Flex>
										{ this.isSourceValid()
											?	<Flex style={ { width: '100%', alignItems: 'center' } }>
													<div style={ { flex: 1 } }>
														<div><span>Type: </span><strong>{ this.state.source.type }</strong></div>
														<div><span>Address: </span><strong>{ this.state.source.address_id }</strong></div>
														{/* <div><span>Assets: </span><strong>{ this.getAssetNames() ?? 'none' }</strong></div> */}
														<div><span>Assets (whitelisted): </span><strong>{ this.state.source.assets ?? 'all' }</strong></div>
													</div>
												</Flex>
											: 	<div style={ { opacity: 0.5 } }>Failed to fetch the source data.</div>
										}
									</Flex>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start" style={{width: '100%'}}>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-source-edit&source=${ this.state.sourceId }` }
								>
									Edit source
								</Button>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-balance-index&address=${ this.state.sourceId }` }
								>
									View balance
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
