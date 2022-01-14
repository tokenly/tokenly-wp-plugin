import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import { TYPES } from '../../../Types';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import UserRepositoryInterface from '../../../Interfaces/Repositories/UserRepositoryInterface';
import SourceStoreForm from '../../Components/Token/SourceStoreForm';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import Preloader from '../../Components/Preloader';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface SourceStorePageData {
	//
}

interface SourceStorePageProps {
	pageData: SourceStorePageData;
}

export default function SourceStorePage ( props: SourceStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );
	
	const [ storing, setStoring ] = useState<boolean>( false );
	const [ loadingAddresses, setLoadingAddresses ] = useState<boolean>( false );
	const [ addresses, setAddresses ] = useState<any>( null );
	const [ storeData, setStoreData ] = useState<any>( {} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-source-index`;
	}

	function onStoreSubmit( event: any ) {
		event.preventDefault();
		const selectedAddress = addresses[ storeData?.address ];
		if ( !selectedAddress ) {
			return;
		}
		const newStoreData = Object.assign( {}, storeData );
		newStoreData.type = addresses[ newStoreData.address ].type;	
		setStoring( true );
		sourceRepository.store( newStoreData ).then( ( result: any ) => {
			setStoring( false );
			goBack();
		} );
	}
	
	function onStoreDataChange( newData: any ) {
		setStoreData( newData );
	}

	function onCancel() {
		goBack();
	}

	useEffect( () => {
		setLoadingAddresses( true );
		const params = {
			registered: true,
		}
		userRepository.tokenAddressIndex( 'me', params ).then( ( addressesFound: any ) => {
			const addressesKeyed = {} as any;
			addressesFound.forEach( ( addressFound: any ) => {
				addressesKeyed[ addressFound.address ] = addressFound;
			} );
			setLoadingAddresses( false );
			setAddresses( addressesKeyed );
		} );
	}, [] );
	
	return (
		<Page title="Source Creator">
			<form onSubmit={ onStoreSubmit }>
				<Panel>
					<PanelHeader>
						<Preloader loading={ loadingAddresses }>Source Form</Preloader>
					</PanelHeader>
				{ ( !loadingAddresses && addresses ) &&
					<PanelBody>
						<PanelRow>
							<SourceStoreForm
								onChange={ onStoreDataChange }
								loadingAddresses={ loadingAddresses }
								addresses={ addresses }
								storeData={ storeData }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Source"
								storing={ storing }
								onCancel={ onCancel }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
