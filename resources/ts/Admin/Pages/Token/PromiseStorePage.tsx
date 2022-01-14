import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import PromiseStoreForm from '../../Components/Token/PromiseStoreForm';
import Preloader from '../../Components/Preloader';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { TYPES } from '../../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface PromiseStorePageData {
	//
}

interface PromiseStorePageProps {
	pageData: PromiseStorePageData;
}

export default function PromiseStorePage( props: PromiseStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const promiseRepository: PromiseRepositoryInterface = useInjection( TYPES.Repositories.Token.PromiseRepositoryInterface );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );
	
	const [ storeData, setStoreData ] = useState<any>( {} );
	const [ sources, setSources ] = useState<any>( null );
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false );
	const [ storing, setStoring ] = useState<boolean>( false );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-vendor`;
	}

	function onStoreSubmit( event: any ) {
		event.preventDefault();
		setStoring( true );
		promiseRepository.store( storeData ).then( ( result: any ) => {
			setStoring( false );
			goBack();
		} );
	}

	function onCancel() {
		goBack();
	}

	function onStoreDataChange( newData: any ) {
		setStoreData( newData );
	}

	useEffect( () => {
		setLoadingSources( true );
		sourceRepository.index( {
			with: [ 'address.balance' ],
		} ).then( ( sourcesFound: any ) => {
			setLoadingSources( false );
			setSources( sourcesFound );
		} )
		.then( () => {
			const newStoreData = {
				quantity: 0,
				pseudo: false,
			}
			setStoreData( newStoreData );
		} );
	}, [] );
	
	return (
		<Page title="Promise Creator">
			<form onSubmit={ onStoreSubmit } >
				<Panel>
					<PanelHeader>
						<Preloader loading={ loadingSources }>Promise Form</Preloader>
					</PanelHeader>
				{ ( !loadingSources && sources ) &&
					<PanelBody>
						<PanelRow>
							<PromiseStoreForm
								onChange={ onStoreDataChange }
								loadingSources={ loadingSources }
								storeData={ storeData }
								sources={ sources }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Promise"
								storing={ storing }
								loading={ ( loadingSources ) }
								onCancel={ onCancel }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
