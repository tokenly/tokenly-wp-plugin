import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './../Page';
import { Component } from 'react';
import * as dayjs from 'dayjs'
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

interface GroupShowPageData {
	//
}

interface GroupShowPageProps {
	pageData: GroupShowPageData;
}

interface GroupShowPageState {
	group: any;
	loadingGroup: boolean;
}

export default class GroupShowPage extends Component<GroupShowPageProps, GroupShowPageState> {
	@resolve( TYPES.Repositories.Credit.GroupRepositoryInterface )
	groupRepository: GroupRepositoryInterface;
	
	state: GroupShowPageState = {
		group: null,
		loadingGroup: null,
	}
	constructor( props: GroupShowPageProps ) {
		super( props );
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
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
			<Page title={ 'Group details' }>
				<div style={ { marginBottom: '8px' } }>
					<a style={ { display: 'inline-block' } } href='/wp-admin/admin.php?page=tokenly-credit-group-index'>Back to the group list</a>
				</div>
				<Panel header={ this.state?.group?.name }>
					<PanelBody>
						<PanelRow>
							<Flex>
								{ this.state.loadingGroup
								?	<Flex justify="flex-start">
										<span>Loading group ... </span>
										<Spinner />
									</Flex>
								:	<Flex>
										{ Object.keys( this.state.group ).length > 0
											?	<Flex style={ { width: '100%', alignItems: 'center' } }>
													<div style={ { flex: 1 } }>
														<div><span>UUID: </span><strong>{ this.state?.group?.uuid }</strong></div>
														<div><span>Active: </span><span><strong>{ this.state?.group?.active ? 'Yes' : 'No' }</strong></span></div>
														<div><span>App whitelist: </span><span><strong>{ this.state?.group?.app_whitelist }</strong></span></div>
														<div><span>Created at: </span><span><strong>{ this.dateFormatted( this.state?.group?.created_at ) }</strong></span></div>
														<div><span>Updated at: </span><span><strong>{ this.dateFormatted( this.state?.group?.updated_at ) }</strong></span></div>
													</div>
												</Flex>
											: 	<div style={ { opacity: 0.5 } }>Failed to fetch the group data.</div>
										}
									</Flex>
								}
							</Flex>
						</PanelRow>
					</PanelBody>
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
