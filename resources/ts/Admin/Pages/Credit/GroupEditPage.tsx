import * as React from 'react'
import { useInjection } from 'inversify-react'
import { useState, useEffect } from 'react'
import Page from '../Page'
import GroupRepositoryInterface from '../../../Interfaces/Repositories/Credit/GroupRepositoryInterface'
import GroupEditForm from '../../Components/Credit/GroupEditForm'
import ResourceEditActions from '../../Components/ResourceEditActions'
import { TYPES } from '../../Types'
import Preloader from '../../Components/Preloader'
import GroupLink from '../../Components/Credit/GroupLink'
import eventBus from "../../../EventBus"

import { 
	Panel,
	PanelHeader,
	PanelBody,
	PanelRow,
} from '@wordpress/components'

declare const window: any

interface GroupEditPageProps {
	//
}

export default function GroupEditPage( props: GroupEditPageProps ) {
	const adminPageUrl: string = useInjection( TYPES.Variables.adminPageUrl )
	const namespace: string = useInjection( TYPES.Variables.namespace )
	const groupRepository: GroupRepositoryInterface = useInjection(
		TYPES.Repositories.Credit.GroupRepositoryInterface
	)
	
	const urlParams = new URLSearchParams( window.location.search )
	const [ uuid, setUuid ] = useState<string>( urlParams.get( 'id' ) )
	const [ group, setGroup ] = useState<any>( null )
	const [ saving, setSaving ] = useState<boolean>( false )
	const [ deleting, setDeleting ] = useState<boolean>( false )
	const [ loadingGroup, setLoadingGroup ] = useState<boolean>( false )
	const [ editData, setEditData ] = useState<any>( {} )

	function goBack() {
		window.location = `${adminPageUrl}${namespace}-credit-group-index`
	}

	function onSaveSubmit( event: any ) {
		event.preventDefault()
		let updateParams = Object.assign( {}, editData )
		let whitelist = updateParams?.app_whitelist.replace( /\s/g, '' )
		if ( whitelist == '' ) {
			updateParams.app_whitelist = []
		} else {
			updateParams.app_whitelist = whitelist.split(',')
		}
		setSaving( true )
		groupRepository.update( uuid, updateParams ).then( ( result: any ) => {
			setSaving( false )
			goBack()
		})
	}

	function onCancel() {
		goBack()
	}

	function onDelete() {
		eventBus.dispatch( 'confirmModalShow', {
			key: 'groupDelete',
			title: 'Deleting Group',
			subtitle: 'Are you sure you want to delete the group?',
		} )
	}

	function onConfirmModalChoice( payload: any ) {
		switch( payload.key ) {
			case 'groupDelete':
				if ( payload.choice == 'accept' ){
					deleteGroup()
				}
				break
		}
	}

	function deleteGroup() {
		setDeleting( true )
		window.location = `https://tokenpass.tokenly.com/auth/apps/credits/${uuid}/delete`
	}

	function onEditDataChange( newData: any ) {
		setEditData( newData )
	}

	useEffect( () => {
		eventBus.on( 'confirmModalChoice', onConfirmModalChoice )
		setLoadingGroup( true )
		groupRepository.show( uuid ).then( ( groupFound: any ) => {
			const editDataNew = {
				name: groupFound.name,
			} as any
			if ( Array.isArray( groupFound.app_whitelist ) ) {
				editDataNew.app_whitelist = groupFound.app_whitelist.join( ', ' )
			} else {
				editDataNew.app_whitelist = ''
			}
			setLoadingGroup( false )
			setGroup( groupFound )
			setEditData( editDataNew )
		} )
		return () => {
			eventBus.remove( 'confirmModalChoice', onConfirmModalChoice )
		}
	 }, [] )

	return (
		<Page title="Group Editor">
			<form onSubmit={ onSaveSubmit }>
				<Panel>
					<PanelHeader>
						<Preloader loading={ loadingGroup }>Group Edit Form</Preloader>
					</PanelHeader>
				{ ( !loadingGroup && group ) &&
					<PanelBody>
						<PanelRow>
							<div>
								<span>Group: </span>
								<GroupLink uuid={ uuid } name={ group.name } />
							</div>
						</PanelRow>
						<PanelRow>
							<GroupEditForm
								onChange={ onEditDataChange }
								loadingGroup={ loadingGroup }
								editData={ editData }
							/>
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ResourceEditActions
								name="Group"
								saving={ saving }
								onCancel={ onCancel }
								onDelete={ onDelete }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</form>
		</Page>
	)
}
