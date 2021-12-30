import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupEditForm from '../../Components/Credit/GroupEditForm';
import ResourceEditActions from '../../Components/ResourceEditActions';
import { TYPES } from '../../../Types';

import { 
	Flex,
	Panel,
	PanelHeader,
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
	editData: any,
}

export default class GroupEditPage extends Component<GroupEditPageProps, GroupEditPageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	
	state: GroupEditPageState = {
		uuid: null,
		group: {},
		saving: false,
		loadingGroup: false,
		editData: {},
	}

	constructor( props: GroupEditPageProps ) {
		super( props );
		this.onSave = this.onSave.bind( this );
		this.onCancel = this.onCancel.bind( this );
		this.onEditDataChange = this.onEditDataChange.bind( this );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.uuid = urlParams.get( 'group' );
	}

	return() {
		window.location = '/wp-admin/admin.php?page=tokenly-credit-group-index';
	}

	onSave() {
		let updateParams = Object.assign( {}, this.state.editData );
		let whitelist = updateParams?.app_whitelist.replace( /\s/g, '' );
		if ( whitelist == '' ) {
			updateParams.app_whitelist = [];
		} else {
			updateParams.app_whitelist = whitelist.split(',');
		}
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
		this.groupRepository.show( this.state.uuid ).then( ( group: any ) => {
			const editData = {
				name: group.name,
			} as any;
			if ( Array.isArray( group.app_whitelist ) ) {
				editData.app_whitelist = group.app_whitelist.join( ', ' );
			} else {
				editData.app_whitelist = '';
			}
			
			this.setState( {
				loadingGroup: false,
				group: group,
				editData: editData,
			} );
		} );
	}

	onEditDataChange( newData: any ) {
		this.setState( { editData: newData } );
	}
	
	render() {
		return (
			<Page title={ 'Group editor' }>
				<Panel>
					<PanelHeader>
						{ this.state.loadingGroup
						?	<Flex justify="flex-start">
								<span>Loading group ... </span>
								<Spinner />
							</Flex>
						:	<span>
								<a href={ `/wp-admin/admin.php?page=tokenly-credit-group-show&group=${this.state.uuid}` }>
									{ this.state.group?.name ?? this.state.uuid }
								</a>
							</span>
						}
					</PanelHeader>
				{ !this.state.loadingGroup &&
					<PanelBody>
						<PanelRow>
							<GroupEditForm
								onChange={ this.onEditDataChange }
								loadingGroup={ this.state.loadingGroup }
								editData={ this.state.editData }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceEditActions
								name="group"
								loading={ this.state.loadingGroup }
								saving={ this.state.saving }
								onSave={ this.onSave }
								onCancel={ this.onCancel }
								noDelete
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
