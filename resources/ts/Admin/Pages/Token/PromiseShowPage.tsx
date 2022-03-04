import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';
import { TYPES } from '../../Types';
import Preloader from '../../Components/Preloader';
import PromiseInfo from '../../Components/Token/PromiseInfo';
import eventBus from "../../../EventBus";
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

declare const window: any;

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
	const [ deleting, setDeleting ] = useState<boolean>( false );

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice );
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
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice );
		}
	}, [] );

	function onDelete() {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'promiseDelete',
			title: 'Deleting Promise',
			subtitle: 'Are you sure you want to delete the promise?',
		} );
	}

	function deletePromise() {
		setDeleting( true );
		promiseRepository.destroy( id ).then( ( result: any ) => {
			setDeleting( false );
			history.back();
		} );
	}

	function onConfirmModalChoice( payload: any ) {
		switch( payload.key ) {
			case 'promiseDelete':
				if ( payload.choice == 'accept' ){
					deletePromise();
				}
				break;
		}
	}

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-promise-index`;
	}
	
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
						<Flex justify="flex-start">
							<Button
								isSecondary
								isLarge
								href={ `${adminPageUrl}${namespace}-token-promise-edit&promise=${ id }` }
							>
								Edit Promise
							</Button>
							<Button
								isDestructive
								onClick={ onDelete }
								isLarge
							>
								Delete Promise
							</Button>
						</Flex>
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
