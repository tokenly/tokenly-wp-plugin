import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import SourceRepositoryInterface from '../../../Interfaces/Repositories/Token/SourceRepositoryInterface';
import { PromiseData } from '../../../Interfaces';
import PromiseList from '../../Components/Token/PromiseList';
import Preloader from '../../Components/Preloader';
import VendorActions from '../../Components/Token/VendorActions';
import { TYPES } from '../../../Types';

import { 
	Panel,
	PanelBody,
	PanelHeader,
	PanelRow,
} from '@wordpress/components';

interface VendorPageData {
	//
}

interface VendorPageProps {
	pageData: VendorPageData;
}

export default function VendorPage( props: VendorPageProps ) {
	const promiseRepository: PromiseRepositoryInterface = useInjection( TYPES.Repositories.Token.PromiseRepositoryInterface );
	const sourceRepository: SourceRepositoryInterface = useInjection( TYPES.Repositories.Token.SourceRepositoryInterface );
	
	const [ promises, setPromises ] = useState<any>( null );
	const [ sources, setSources ] = useState<any>( {} );
	const [ loadingPromises, setLoadingPromises ] = useState<boolean>( false );
	const [ loadingSources, setLoadingSources ] = useState<boolean>( false );

	useEffect( () => {
		setLoadingPromises( true );
		setLoadingSources( true );
		promiseRepository.index( {
			with: [ 'promise_meta.source_user', 'promise_meta.destination_user' ],
		} ).then( ( promisesFound ) => {
			setLoadingPromises( false );
			setPromises( promisesFound );
			if ( Array.isArray( promisesFound ) && promisesFound.length === 0 ) {
				setLoadingSources( false );
				return;
			}
			sourceRepository.index( {
				with: [ 'address' ],
			} ).then( ( sourcesFound ) => {
				promisesFound = promisesFound.map( ( promiseFound: any ) => {
					promiseFound.source = sourcesFound[ promiseFound.source_id ];
					return promiseFound;
				} );
				setLoadingSources( false );
				setPromises( promisesFound );
				setSources( sourcesFound );
			} );
		} );
	}, [] );

	return (
		<Page title="Token Vendor">
			<Panel header="Vendor Actions">
				<PanelBody>
					<PanelRow>
						<VendorActions />
					</PanelRow>
				</PanelBody>
			</Panel>
			<Panel>
				<PanelHeader>
					<Preloader loading={ ( loadingPromises || loadingSources ) }>Registered Promises</Preloader>
				</PanelHeader>
			{ ( !loadingPromises && promises ) &&
				<PanelBody>
					<PanelRow>
						<PromiseList promises={ promises } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
		</Page>
	);
}
