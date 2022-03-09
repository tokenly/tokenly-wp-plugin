import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import Page from '../Page';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupStoreForm from '../../Components/Credit/GroupStoreForm';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import { TYPES } from '../../Types';

declare const window: any;

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface GroupStorePageProps {
	client_id: string;
}

export default function GroupStorePage( props: GroupStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	
	const [ storing, setStoring ] = useState<boolean>( false );
	const [ storeData, setStoreData ] = useState<any>( {
		name: 'New Group',
		app_whitelist: props.client_id,
	} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-credit-group-index`;
	}
	
	function onStoreSubmit( event: any ) {
		event.preventDefault();
		setStoring( true );
		groupRepository.store( storeData ).then( ( result: any ) => {
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

	return (
		<Page title="Group Creator">
			<form onSubmit={ onStoreSubmit }>
				<Panel>
					<PanelBody>
						<PanelRow>
							<GroupStoreForm
								storeData={ storeData }
								onChange={ onStoreDataChange }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name="Group"
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
