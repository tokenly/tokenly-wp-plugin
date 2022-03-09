import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import UserRepositoryInterface from '../../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../Types';
import Page from '../Page';
import AddressList from '../../Components/Token/AddressList';
import Preloader from '../../Components/Preloader';
import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface AddressIndexPageProps {
	//
}

export default function AddressIndexPage( props: AddressIndexPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );

	const [ addresses, setAddresses ] = useState<any>( null );
	const [ sources, setSources ] = useState<any>( null );
	const [ loadingAddresses, setLoadingAddresses ] = useState<boolean>( false );
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false );

	useEffect( () => {
		setLoadingAddresses( true );
		setLoadingSources( true );
		userRepository.show('me', {
			with: [ 'oauth_user' ],
		} ).then( ( user: any ) => {
			if ( user && user.oauth_user ) {
				addressRepository.index().then( ( addressesFound: any ) => {
					addressesFound = Object.values( addressesFound );
					setLoadingAddresses( false );
					setAddresses( addressesFound );
					return addressesFound;
				} ).then( ( addressesFound ) => {
					addressesFound = Object.assign( [], addressesFound );
					sourceRepository.index().then( ( sourcesFound: any ) => {
						setLoadingSources( false );
						setSources( sourcesFound );
						addressesFound.forEach( ( address: any ) => {
							address.isSource = ( address.address in sourcesFound );
						} );
						setAddresses( addressesFound );
					} );
				} );
			}
		} );
	}, [] );
	
	return (
		<Page title="Address Listing">
			<Panel header="Address Actions">
				<PanelBody>
					<PanelRow>
						<Flex style={ { width: '100%' } }>
							<Button
								isPrimary
								href={ `${adminPageUrl}${namespace}-token-address-store` }
							>
								Register Address
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingAddresses }>Registered Addresses</Preloader>
				</PanelHeader>
			{
				(
					!loadingAddresses &&
					addresses &&
					typeof addresses === 'object'
				) &&
				<PanelBody>
					<PanelRow>
						<AddressList addresses={ addresses } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
