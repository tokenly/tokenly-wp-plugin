import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TYPES } from '../../../Types';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import Page from './../Page';
import Preloader from '../../Components/Preloader';
import SourceLink from '../../Components/Token/SourceLink';
import SourceInfo from '../../Components/Token/SourceInfo';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
} from '@wordpress/components';

interface SourceShowPageData {
	//
}

interface SourceShowPageProps {
	pageData: SourceShowPageData;
}

interface SourceShowPageState {
	id: string,
	source: any,
	loading: boolean,
}

export default class SourceShowPage extends Component<SourceShowPageProps, SourceShowPageState> {
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;

	state: SourceShowPageState = {
		id: null,
		source: null,
		loading: false,
	}
	constructor( props: SourceShowPageProps ) {
		super( props );
		this.getAssetNames = this.getAssetNames.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'source' );
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
		this.sourceRepository.show( this.state.id, params ).then( ( source: any ) => {
			this.setState( {
				loading: false,
				source: source,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={ 'Source display' }>
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loading } label="source" />
					{ !this.state.loading &&
						<SourceLink id={ this.state.id } label={ this.state.source?.address?.label } text />
					}
					</PanelHeader>
				{ !this.state.loading &&
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.isSourceValid()
									?	<SourceInfo source={ this.state.source } />
									: 	<div style={ { opacity: 0.5 } }>Failed to fetch the source data.</div>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start" style={{width: '100%'}}>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-source-edit&source=${ this.state.id }` }
								>
									Edit source
								</Button>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-token-balance-index&address=${ this.state.id }` }
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
