import * as React from 'react'
import { useState } from 'react'
import { useInjection } from 'inversify-react'
import Page from '../Page'
import AddressRepositoryInterface
	from '../../../Interfaces/Repositories/Token/AddressRepositoryInterface'
import AddressStoreForm from '../../Components/Token/AddressStoreForm'
import ResourceStoreActions from '../../Components/ResourceStoreActions'
import { TYPES } from '../../../Types'

declare const window: any

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components'
import RouteManagerInterface from '../../../Interfaces/Models/RouteManagerInterface'

interface AddressStorePageProps {
	//
}

export default function AddressStorePage( props: AddressStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl )
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const routes: RouteManagerInterface = useInjection( TYPES.Variables.routes )
	const addressRepository: AddressRepositoryInterface = useInjection(
		TYPES.Repositories.Token.AddressRepositoryInterface
	)
	
	const [ storeData, setStoreData ] = useState<any>( {
		address: null,
		label: 'New Address',
		public: false,
		type: 'bitcoin',
	} )
	const [ storing, setStoring ] = useState<boolean>( false )

	function goBack() {
		window.location = routes.get( 'admin', 'token_address_index' )
	}

	function onStoreSubmit( event: any ) {
		event.preventDefault()
		setStoring( true )
		addressRepository.store( storeData ).then( ( result: any ) => {
			setStoring( false )
			window.location = routes.get(
				'admin',
				'token_address_show',
				{
					address : storeData.address
				}
			)
		} )
	}

	function onCancel() {
		goBack()
	}

	function onStoreDataChange( newData: any ) {
		setStoreData( newData )
	}
	
	return (
		<Page title="Address Creator">
			<form onSubmit={ onStoreSubmit } >
				<Panel>
					<PanelHeader>
						<span>Address Form</span>
					</PanelHeader>
					<PanelBody>
						<PanelRow>
							<AddressStoreForm
								onChange={ onStoreDataChange }
								storeData={ storeData }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Address"
								storing={ storing }
								onCancel={ onCancel }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	)
}
