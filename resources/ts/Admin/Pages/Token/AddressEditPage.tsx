import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import { TYPES } from '../../Types';
import Page from './../Page';
import AddressEditForm from '../../Components/Token/AddressEditForm';
import Preloader from '../../Components/Preloader';
import ResourceEditActions from '../../Components/ResourceEditActions';
import AddressRepositoryInterface from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';

declare const window: any;

interface AddressEditPageProps {
	//
}

export default function AddressEditPage( props: AddressEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const addressRepository: AddressRepositoryInterface = useInjection( TYPES.Repositories.Token.AddressRepositoryInterface );
	
	const urlParams = new URLSearchParams( window.location.search );

	const [ saving, setSaving ] = useState<boolean>( false );
	const [ loading, setLoading ] = useState<boolean>( false );
	const [ address, setAddress ] = useState<any>( null );
	const [ id, setId ] = useState<string>( urlParams.get( 'address' ) );
	const [ editData, setEditData ] = useState<any>( {} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-token-address-index`;
	}

	function onSaveSubmit( event: any ) {
		event.preventDefault();
		setSaving( true );
		addressRepository.update( id, editData ).then( ( result: any ) => {
			setSaving( false );
			//goBack();
		} );
	}

	function onCancel() {
		goBack();
	}
	
	function onEditDataChange( newData: any ) {
		setEditData( newData );
	}

	useEffect( () => {
		setLoading( true );
		addressRepository.show( id ).then( ( addressFound: any ) => {
			const newEditData = {
				address: addressFound?.address,
				label: addressFound?.label,
				public: addressFound?.public,
				active: addressFound?.active,
				type: addressFound?.type,
			} as any;
			setLoading( false );
			setAddress( addressFound );
			setEditData( newEditData );
		} );
	}, [] );
	
	return (
		<Page title="Address Editor">
			<form onSubmit={ onSaveSubmit } >
				<Panel>
					<PanelHeader>
						<Preloader loading={ loading } >
							<span>Address Form</span>
						</Preloader>
					</PanelHeader>
				{ ( !loading && address ) &&
					<PanelBody>
						<PanelRow>
							<AddressEditForm
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
								name="Address"
								saving={ saving }
								onCancel={ onCancel }
								noDelete
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
