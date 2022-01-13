import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TYPES } from '../../../Types';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
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
	loadingSource: boolean,
	loadingAddress: boolean,
}

export default class SourceShowPage extends Component<SourceShowPageProps, SourceShowPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.AddressRepositoryInterface )
	addressRepository: AddressRepositoryInterface;
	@resolve( TYPES.Repositories.Token.SourceRepositoryInterface )
	sourceRepository: SourceRepositoryInterface;

	state: SourceShowPageState = {
		id: null,
		source: null,
		loadingSource: false,
		loadingAddress: false,
	}
	constructor( props: SourceShowPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'source' );
	}

	isSourceValid() {
		return ( this.state.source && typeof this.state.source === 'object' );
	}

	componentWillMount() {
		this.setState( {
			loadingSource: true,
			loadingAddress: true,
		} );
		this.sourceRepository.show( this.state.id ).then( ( source: any ) => {
			this.setState( {
				loadingSource: false,
				source: source,
			} );
			return source;
		} )
		.then( ( source: any ) => {
			this.addressRepository.show( source.address_id ).then( ( address: any ) => {
				source.address = address;
				this.setState( {
					source: source,
					loadingAddress: false,
				} );
			} )
		} )
	}
	
	render() {
		return (
			<Page title="Source Display">
				<Panel>
					<PanelHeader>
						<Preloader loading={ ( this.state.loadingSource || this.state.loadingAddress ) }>Source Info</Preloader>
					</PanelHeader>
				{ !this.state.loadingSource &&
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
							<Flex justify="flex-start">
								<Button
									isSecondary
									isLarge
									href={ `${this.adminPageUrl}${this.namespace}-token-source-edit&source=${this.state.id}` }
								>
									Edit Source
								</Button>
								<Button
									isSecondary
									isLarge
									href={ `${this.adminPageUrl}${this.namespace}-token-address-balance-index&id=${this.state.id}` }
								>
									View Balance
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
