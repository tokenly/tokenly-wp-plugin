import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';

import { 
	Button,
	Flex,
	Dashicon,
	Card,
	CardBody,
	CardHeader,
	CardFooter,
} from '@wordpress/components';

interface SourceListProps {
	sourceList: Array<SourceItem>;
}

interface SourceListState {
	//
}

export class SourceList extends Component<SourceListProps, SourceListState> {

	constructor( props: SourceListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.sourceList ).map( ( key: any ) => this.props.sourceList[ key ] ) as any;
		listItems = listItems.map( ( sourceItem: SourceItem, i: number ) => {
			let assets = 'all';
			if ( sourceItem?.assets?.length ) {
				assets = sourceItem?.assets?.join( ', ' );
			}
			return (
				<div style={ { width: '100%' } }>
					<Card size="extraSmall" style={ { width: '100%' } }>
						<CardHeader>
							<div title={ sourceItem.address }><strong>{ sourceItem.address_data?.label }</strong></div>
						</CardHeader>
						<CardBody style={ { width: '100%' } }>
							<Flex style={ { width: '100%', alignItems: 'center' } }>
								<div style={ { flex: 1 } }>
									<div><span>Assets (whitelisted): </span><strong>{ assets }</strong></div>
								</div>
							</Flex>
						</CardBody>
						<CardFooter>
							<Flex justify="flex-start">
								<Button
									isSecondary
									isSmall
									href={ `/wp-admin/admin.php?page=tokenpass-source-show&source=${ sourceItem.address }` }
								>
									Details
								</Button>
								<Button
									isSecondary
									isSmall
									href={ `/wp-admin/admin.php?page=tokenpass-source-edit&source=${ sourceItem.address }` }
								>
									Manage source
								</Button>
							</Flex>
						</CardFooter>
					</Card>
				</div>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no registered sources</div>
				}
			</div>
		);
	}
}
