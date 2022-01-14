import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import Page from './../Page';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupStoreForm from '../../Components/Credit/GroupStoreForm';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import { TYPES } from '../../../Types';

declare const window: any;

import { 
	Panel,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface GroupStorePageData {
	client_id: string;
}

interface GroupStorePageProps {
	pageData: GroupStorePageData;
}

export default function GroupStorePage( props: GroupStorePageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl );
	const namespace: string = useInjection( TYPES.Variables.namespace );
	const groupRepository: GroupRepositoryInterface = useInjection( TYPES.Repositories.Credit.GroupRepositoryInterface );
	
	const [ storing, setStoring ] = useState<boolean>( false );
	const [ storeData, setStoreData ] = useState<any>( {
		name: 'New Group',
		app_whitelist: props.pageData?.client_id,
	} );

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-credit-vendor`;
	}
	
	function onStore() {
		setStoring( true );
		groupRepository.store( storeData ).then( ( result: any ) => {
			setStoring( false );
			goBack();
		} );
	}

	function isStoreDisabled() {
		return ( !storeData?.name || !storeData?.app_whitelist );
	}

	function onCancel() {
		goBack();
	}

	function onStoreDataChange( newData: any ) {
		setStoreData( newData );
	}

	return (
		<Page title="Group Creator">
			<form>
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
								onStore={ onStore }
								onCancel={ onCancel }
								disableStore={ isStoreDisabled() }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	);
}
