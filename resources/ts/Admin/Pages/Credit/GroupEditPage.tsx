import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupEditForm from '../../Components/Credit/GroupEditForm';
import { TYPES } from '../../../Types';

import { 
	Flex,
	Panel,
	PanelBody,
	PanelRow,
	Spinner,
} from '@wordpress/components';

declare const window: any;

interface GroupEditPageData {
	//
}

interface GroupEditPageProps {
	pageData: GroupEditPageData;
}

interface GroupEditPageState {
	uuid: string;
	group: any;
	saving: boolean;
	loadingGroup: boolean;
}

export default class GroupEditPage extends Component<GroupEditPageProps, GroupEditPageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	
	state: GroupEditPageState = {
		uuid: null,
		group: {},
		saving: false,
		loadingGroup: false,
	}

	constructor( props: GroupEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onCancel = this.onCancel.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.uuid = urlParams.get( 'group' );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}

	onSave( creditGroup: any ) {
		let updateParams = Object.assign( {}, creditGroup );
		this.setState( { saving: true } );
		this.groupRepository.update( this.state.uuid, updateParams ).then( ( result: any ) => {
			this.setState( { saving: false } );
			this.return();
		});
	}

	onCancel() {
		this.return();
	}

	componentWillMount() {
		this.setState( { loadingGroup: true } );
		const urlParams = new URLSearchParams( window.location.search );
		const group = urlParams.get( 'group' );
		this.groupRepository.show( group ).then( ( group: any ) => {
			this.setState( {
				loadingGroup: false,
				group: group,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={ 'Group editor' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to group list</a>
				</div>
				<Panel>
					<PanelBody>
						<PanelRow>
							<GroupEditForm
								loadingGroup={ this.state.loadingGroup }
								onSave={ this.onSave }
								onCancel={ this.onCancel }
								saving={ this.state.saving }
								group={ this.state.group }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
