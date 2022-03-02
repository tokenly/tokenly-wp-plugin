import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import Page from './../Page';
import PromiseLink from '../../Components/Token/PromiseLink';
import PromiseEditForm from '../../Components/Token/PromiseEditForm';
import Preloader from '../../Components/Preloader';
import ResourceEditActions from '../../Components/ResourceEditActions';
import { PromiseData, PromiseUpdateParams } from '../../../Interfaces';
import eventBus from "../../../EventBus";
import PromiseRepositoryInterface from '../../../Interfaces/Repositories/Token/PromiseRepositoryInterface';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';

declare const window: any;

interface PromiseEditPageProps {
	//
}

export default function PromiseEditPage( props: PromiseEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const promiseRepository: PromiseRepositoryInterface = useInjection( TYPES.Repositories.Token.PromiseRepositoryInterface );
	
	const urlParams = new URLSearchParams( window.location.search );

	const [ saving, setSaving ] = useState<boolean>( false );
	const [ deleting, setDeleting ] = useState<boolean>( false );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ promise, setPromise ] = useState<any>( null );
	const [ id, setId ] = useState<number>( parseInt( urlParams.get( 'promise' ) ) );
	const [ editData, setEditData ] = useState<any>( {} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-promise-index`;
	}

	function onSaveSubmit( event: any ) {
		event.preventDefault();
		setSaving( true );
		promiseRepository.update( id, editData ).then( ( result: any ) => {
			setSaving( false );
			goBack();
		});
	}

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
			goBack();
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

	function onCancel() {
		goBack();
	}
	
	function onEditDataChange( newData: any ) {
		setEditData( newData );
	}

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice );
		setLoading( true );
		promiseRepository.show( id ).then( ( promiseFound: any ) => {
			const newEditData = {
				quantity: Object.assign( {}, promiseFound?.quantity ),
				expiration: null,
				txid: null,
				fingerprint: null,
				ref: promiseFound?.ref,
				note: promiseFound?.note,
			} as any;
			setLoading( false );
			setPromise( promiseFound );
			setEditData( newEditData );
		} );
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice );
		}
	}, [] );
	
	return (
		<Page title="Promise Editor">
			<form onSubmit={ onSaveSubmit } >
				<Panel>
					<PanelHeader>
						<Preloader loading={ loading } >
							<PromiseLink id={ id } />
						</Preloader>
					</PanelHeader>
				{ ( !loading && promise ) &&
					<PanelBody>
						<PanelRow>
							<PromiseEditForm
								onChange={ onEditDataChange }
								editData={ editData }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceEditActions
								name="Promise"
								saving={ saving }
								deleting={ deleting }
								onDelete={ onDelete }
								onCancel={ onCancel }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
