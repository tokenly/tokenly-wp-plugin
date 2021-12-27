import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupStoreForm from '../../Components/Credit/GroupStoreForm';
import { TYPES } from '../../../Types';

declare const window: any;

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components';

interface GroupStorePageData {
	client_id: string;
}

interface GroupStorePageProps {
	pageData: GroupStorePageData;
	saving: boolean;
}

interface GroupStorePageState {
	storingCreditGroup: boolean;
	address: any;
}

export default class GroupStorePage extends Component<GroupStorePageProps, GroupStorePageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	
	state: GroupStorePageState = {
		storingCreditGroup: false,
		address: null,
	}
	constructor( props: GroupStorePageProps ) {
		super( props );
		this.onSubmit = this.onSubmit.bind( this );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}
	
	onSubmit( creditGroup: any ) {
		this.setState( {
			storingCreditGroup: true,
		} );
		this.groupRepository.store( creditGroup ).then( ( result: any ) => {
			this.setState( {
				storingCreditGroup: false,
			} );
			this.return();
		});
	}
	
	render() {
		return (
			<Page title={'Group creator'}>
				<div style={ { marginBottom: '8px' } }>
					<a href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to credit group list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<GroupStoreForm
								onSubmit={ this.onSubmit }
								onCancel={ this.return }
								saving={ this.state.storingCreditGroup }
								style={ { marginBottom: '12px' } }
								client_id={ this.props.pageData.client_id }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
