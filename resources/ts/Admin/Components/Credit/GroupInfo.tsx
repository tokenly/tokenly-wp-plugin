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
				{ this.props.verbose &&
					<div>
						<div>
							<span>Name: </span>
							<b>{ this.props?.group?.name }</b>
						</div>
						<div>
							<span>UUID: </span>
							<b>{ this.props?.group?.uuid }</b>
						</div>
						<div>
							<span>App Whitelist: </span>
							<b>{ this.props?.group?.app_whitelist }</b>
						</div>
						<div>
							<span>Created At: </span>
							<b>{ this.dateFormatted( this.props?.group?.created_at ) }</b>
						</div>
						<div>
							<span>Updated At: </span>
							<b>{ this.dateFormatted( this.props?.group?.updated_at ) }</b>
						</div>
					</div>
				}
					<div>
						<span>Active: </span>
						<b>{ this.props?.group?.active ? 'Yes' : 'No' }</b>
					</div>
				</div>
			</Flex>
		);
	}
}
