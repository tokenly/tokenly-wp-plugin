import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { TYPES } from '../../../../Types';
import AddressRepositoryInterface from '../../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import Page from './../../Page';
import Preloader from '../../../Components/Preloader';
import SourceLink from '../../../Components/Token/SourceLink';
import AddressInfo from '../../../Components/Token/AddressInfo';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	PanelHeader,
} from '@wordpress/components';

interface AddressShowPageData {
	//
}

interface AddressShowPageProps {
	pageData: AddressShowPageData;
}

interface AddressShowPageState {
	id: string,
	address: any,
	loading: boolean,
}

export default class AddressShowPage extends Component<AddressShowPageProps, AddressShowPageState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
	@resolve( TYPES.Repositories.Token.AddressRepositoryInterface )
	addressRepository: AddressRepositoryInterface;

	state: AddressShowPageState = {
		id: null,
		address: null,
		loading: false,
	}
	constructor( props: AddressShowPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.id = urlParams.get( 'id' );
	}

	componentWillMount() {
		this.setState( { loading: true } );
		this.addressRepository.show( this.state.id ).then( ( address: any ) => {
			this.setState( {
				loading: false,
				address: address,
			} );
		} );
	}
	
	render() {
		return (
			<Page title="Address Display">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loading }>Address Info</Preloader>
					</PanelHeader>
				{ !this.state.loading &&
					<PanelBody>
						<PanelRow>
							<AddressInfo address={ this.state.address } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
			</Page>
		);
	}
}
