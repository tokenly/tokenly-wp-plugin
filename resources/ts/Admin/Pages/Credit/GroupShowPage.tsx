import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import { TYPES } from '../../../Types';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import GroupInfo from '../../Components/Credit/GroupInfo';
import Preloader from '../../Components/Preloader';
import GroupLink from '../../Components/Credit/GroupLink';

import { 
	Button,
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
	Flex,
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
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;
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
			<Page title="Group Details">
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingGroup }>Group Info</Preloader>
					</PanelHeader>
				{ !this.state.loadingGroup &&
					<PanelBody>
						<PanelRow>
					{ Object.keys( this.state.group ).length > 0
						?	<GroupInfo group={ this.state.group } verbose />
						: 	<div style={ { opacity: 0.5 } }>Failed to fetch the group data.</div>
					}
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex justify="flex-start">
								<Button
									isSecondary
									isLarge
									href={ `${this.adminPageUrl}${this.namespace}-credit-group-edit&group=${ this.state?.group?.uuid }` }
								>
									Manage Group
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
