import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import { TYPES } from '../../Types';
import Preloader from '../../Components/Preloader';
import PromiseInfo from '../../Components/Token/PromiseInfo';
import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface PromiseShowPageProps {
	//
}

export default function PromiseShowPage( props: PromiseShowPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const promiseRepository: PromiseRepositoryInterface = useInjection( TYPES.Repositories.Token.PromiseRepositoryInterface );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );

	const urlParams = new URLSearchParams( window.location.search );
	const [ id, setId ] = useState<number>( parseInt( urlParams.get( 'promise' ) ) );
	const [ promise, setPromise ] = useState<any>( null );
	const [ loadingPromise, setLoadingPromise ] = useState<boolean>( false );
	const [ loadingAddress, setLoadingAddress ] = useState<boolean>( false );

	useEffect( () => {
		setLoadingPromise( true );
		setLoadingAddress( true );
		const params = {
			with: [
				'promise_meta.source_user',
				'promise_meta.destination_user',
			],
		}
		promiseRepository.show( id, params ).then( ( promiseFound: any ) => {
			setLoadingPromise( false );
			setPromise( promiseFound );
			return promiseFound;
		} ).then( ( promiseFound: any ) => {
			addressRepository.show( promiseFound.source_id ).then( ( addressFound: any ) => {
				promiseFound.source = {};
				promiseFound.source.address = addressFound;
				setLoadingAddress( false );
				setPromise( promiseFound );
			} );
		} );
	}, [] );
	
	return (
		<Page title="Promise Display">
			<Panel>
				<PanelHeader>
					<Preloader loading={ ( loadingPromise || loadingAddress ) }>
						Promise Info
					</Preloader>
				</PanelHeader>
				{ ( !loadingPromise && promise ) &&
				<PanelBody>
					<PanelRow>
						<PromiseInfo promise={ promise } verbose />
					</PanelRow>
				</PanelBody>
				}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<Flex>
							<Button
								isSecondary
								isLarge
								href={ `${adminPageUrl}${namespace}-token-promise-edit&promise=${ id }` }
							>
								Manage Promise
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
