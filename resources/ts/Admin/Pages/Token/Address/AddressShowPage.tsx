import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../../../Types';
import AddressRepositoryInterface from '../../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import Page from './../../Page';
import Preloader from '../../../Components/Preloader';
import AddressInfo from '../../../Components/Token/AddressInfo';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';

interface AddressShowPageData {
	//
}

interface AddressShowPageProps {
	pageData: AddressShowPageData;
}

export default function AddressShowPage( props: AddressShowPageProps ) {
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
			{ ( !loading && address ) &&
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
