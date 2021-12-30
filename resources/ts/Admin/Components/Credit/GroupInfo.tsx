import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs'

import { 
	Flex,
} from '@wordpress/components';

interface GroupInfoProps {
	group: any;
	verbose?: boolean;
}

interface GroupInfoState {
	//
}

export default class GroupInfo extends Component<GroupInfoProps, GroupInfoState> {
	constructor( props: GroupInfoProps ) {
		super( props );
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	render() {
		return (
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<div>
						<span>Active: </span>
						<strong>{ this.props?.group?.active ? 'Yes' : 'No' }</strong>
					</div>
				{ this.props.verbose &&
					<div>
						<div>
							<span>UUID: </span>
							<strong>{ this.props?.group?.uuid }</strong>
						</div>
						<div>
							<span>App whitelist: </span>
							<strong>{ this.props?.group?.app_whitelist }</strong>
						</div>
						<div>
							<span>Created at: </span>
							<strong>{ this.dateFormatted( this.props?.group?.created_at ) }</strong>
						</div>
						<div>
							<span>Updated at: </span>
							<strong>{ this.dateFormatted( this.props?.group?.updated_at ) }</strong>
						</div>
					</div>
				}
				</div>
			</Flex>
		);
	}
}
