import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
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

export default function AddressShowPage( props: AddressShowPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );

	const urlParams = new URLSearchParams( window.location.search );
	const [ id, setId ] = useState<string>( urlParams.get( 'id' ) );
	const [ address, setAddress ] = useState<any>( null );
	const [ loading, setLoading ] = useState<boolean>( false );

	useEffect( () => {
		setLoading( true );
		addressRepository.show( id ).then( ( addressFound: any ) => {
			setLoading( false );
			setAddress( addressFound );
		} );
	 }, [] );
	
	return (
		<Page title="Address Display">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loading }>Address Info</Preloader>
				</PanelHeader>
			{ !loading &&
				<PanelBody>
					<PanelRow>
						<AddressInfo address={ address } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
