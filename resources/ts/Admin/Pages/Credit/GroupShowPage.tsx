import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupInfo from '../../Components/Credit/GroupInfo';
import { TYPES } from '../../../Types';

import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface GroupShowPageData {
	//
}

interface GroupShowPageProps {
	pageData: GroupShowPageData;
}

interface GroupShowPageState {
	uuid: string;
	group: any;
	loadingGroup: boolean;
}

export default class GroupShowPage extends Component<GroupShowPageProps, GroupShowPageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	
	state: GroupShowPageState = {
		uuid: null,
		group: null,
		loadingGroup: null,
	}
	constructor( props: GroupShowPageProps ) {
		super( props );
		const urlParams = new URLSearchParams( window.location.search );
		this.state.uuid = urlParams.get( 'group' );
	}

	componentWillMount() {
		this.setState( { loadingGroup: true } );
		this.groupRepository.show( this.state.uuid ).then( ( group: any ) => {
			this.setState( {
				loadingGroup: false,
				group: group,
			} );
		} );
	}

	render() {
		return (
			<Page title={ 'Group details' }>
				<Panel>
					<PanelHeader>
						{ this.state.loadingGroup
						?	<Flex justify="flex-start">
								<span>Loading group ... </span>
								<Spinner />
							</Flex>
						:	<span>{ this.state.group?.name ?? this.state.uuid }</span>
						}
					</PanelHeader>
				{ !this.state.loadingGroup &&
					<PanelBody>
						<PanelRow>
							<Flex>
						{ Object.keys( this.state.group ).length > 0
							?	<GroupInfo group={ this.state.group } />
							: 	<div style={ { opacity: 0.5 } }>Failed to fetch the group data.</div>
						}
							</Flex>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start" style={{width: '100%'}}>
								<Button
									isSecondary
									isLarge
									href={ `/wp-admin/admin.php?page=tokenly-credit-group-edit&group=${ this.state?.group?.uuid }` }
								>
									Manage group
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
