import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupStoreForm from '../../Components/Credit/GroupStoreForm';
import ResourceStoreActions from '../../Components/ResourceStoreActions';
import { TYPES } from '../../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface GroupStorePageData {
	client_id: string;
}

interface GroupStorePageProps {
	pageData: GroupStorePageData;
}

interface GroupStorePageState {
	storing: boolean;
	storeData: any;
}

export default class GroupStorePage extends Component<GroupStorePageProps, GroupStorePageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	
	state: GroupStorePageState = {
		storing: false,
		storeData: {},
	}
	constructor( props: GroupStorePageProps ) {
		super( props );
		this.onStore = this.onStore.bind( this );
		this.onCancel = this.onCancel.bind( this );
		this.onStoreDataChange = this.onStoreDataChange.bind( this );
		this.state.storeData.name = 'New group';
		this.state.storeData.app_whitelist = this.props.pageData?.client_id;
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}
	
	onStore() {
		this.setState( {
			storing: true,
		} );
		this.groupRepository.store( this.state.storeData ).then( ( result: any ) => {
			this.setState( {
				storing: false,
			} );
			this.return();
		});
	}

	isStoreDisabled() {
		return ( !this.state.storeData?.name || !this.state.storeData?.app_whitelist );
	}

	onCancel() {
		this.return();
	}

	onStoreDataChange( newData: any ) {
		this.setState( { storeData: newData } );
	}
	
	render() {
		return (
			<Page title={'Group creator'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<GroupStoreForm
								storeData={ this.state.storeData }
								onChange={ this.onStoreDataChange }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceStoreActions
								name={ 'group' }
								storing={ this.state.storing }
								onStore={ this.onStore }
								onCancel={ this.onCancel }
								disableStore={ this.isStoreDisabled() }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
