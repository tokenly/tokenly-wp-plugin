import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import GroupList from '../../Components/Credit/GroupList';
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface';
import { TYPES } from '../../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
	Spinner,
} from '@wordpress/components';

interface GroupIndexPageData {
	//
}

interface GroupIndexPageProps {
	pageData: GroupIndexPageData;
}

interface GroupIndexPageState {
	loadingGroups: boolean;
	groups: any;
}

export default class GroupIndexPage extends Component<GroupIndexPageProps, GroupIndexPageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;

	state: GroupIndexPageState = {
		loadingGroups: false,
		groups: {},
	}
	constructor( props: GroupIndexPageProps ) {
		super( props );
	}

	componentWillMount() {
		this.setState( { loadingGroups: true } );
		this.groupRepository.index().then( ( groups ) => {
			this.setState( {
				loadingGroups: false,
				groups: groups,
			} );
		} );
	}
	
	render() {
		return (
			<Page title={'Group listing'}>
				<Panel>
					<PanelBody>
						<PanelRow>
							<Flex
								justify="flex-start"
								style={ { width: '100%' } }
							>
								<Button
									isPrimary
									href='/wp-admin/admin.php?page=tokenly-credit-transaction-store'
								>
									Make transaction
								</Button>
								<Button
									isPrimary
									href='/wp-admin/admin.php?page=tokenly-credit-group-store'
								>
									Register group
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
				<Panel header="Registered groups">
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.loadingGroups
								?	<Flex justify="flex-start">
										<span>Loading groups ... </span>
										<Spinner />
									</Flex>
								:	<Flex>
										{ Object.keys( this.state.groups ).length > 0
											? <GroupList
												groups={ this.state.groups }
												loadingGroups={ this.state.loadingGroups }
											/>
											: <div style={ { opacity: 0.5 } }>There are no registered groups</div>
										}
									</Flex>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
